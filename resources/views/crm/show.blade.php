@include('role_header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
  :root{--muted:#6b7280;--soft:#f3f4f6;--ring:#e5e7eb;--brand:#0d6efd;--grad:linear-gradient(to right,#007bff,#00c6ff)}
  html,body{font-size:12px;background:#fff}
  a{text-decoration:none}
  .card{border:1px solid var(--ring);border-radius:14px;overflow:hidden}
  .card-header{background:#fff;border-bottom:1px solid var(--ring)}
  .nav-tabs{border:0;gap:.25rem}
  .nav-tabs .nav-link{border:0;border-bottom:3px solid transparent;color:#111827;font-weight:600}
  .nav-tabs .nav-link.active{color:var(--brand);border-color:var(--brand);background:transparent}
  .toolbar{display:flex;align-items:center;justify-content:flex-end;gap:.4rem}
  .toolbar .btn{padding:.25rem .55rem;font-size:.75rem;border-radius:.35rem}
  .btn-icon{display:inline-flex;align-items:center;gap:.4rem}
  .table-container{width:100%;overflow-x:auto}
  table.table{width:100%;border-collapse:separate;border-spacing:0}
  .table thead th{background-image:var(--grad);color:#fff;text-transform:uppercase;letter-spacing:.02em;font-size:12px;padding:.7rem .85rem;position:sticky;top:0;z-index:1}
  .table tbody td,.table tfoot td{padding:.6rem .85rem;vertical-align:middle;font-size:12px}
  .table tbody tr:nth-of-type(odd){background:var(--soft)}
  .table tfoot td{font-weight:700;background-image:var(--grad);color:#fff;border-top:0}
  .summary-grid{display:grid;grid-template-columns:200px 1fr 1fr;gap:.5rem 1.25rem}
  .summary-grid .label{color:var(--muted)}
  .header-row{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem}
  .brand-title{font-size:18px;font-weight:800;letter-spacing:.3px}
  .subtle{color:var(--muted)}
  .badge-soft{background:#eef2ff;color:#3730a3;border:1px solid #e0e7ff}
  .section-title{font-weight:800;font-size:13px;margin-bottom:.6rem}
  .w-110{width:110px}.w-140{width:140px}.w-160{width:160px}.w-220{width:220px}
  .text-mono{font-variant-numeric:tabular-nums;font-feature-settings:"tnum"}
  .modal-body-view{min-height:70vh;display:flex;align-items:center;justify-content:center;background:#fff}
</style>

@php
  $num=function($v){ if(is_null($v)||$v==='') return 0.0; if(is_numeric($v)) return (float)$v; if(is_string($v)) return (float)str_replace([',',' '],'',$v); return (float)$v; };
  $user = auth()->user();
  $printedBy = $user ? (trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->name ?? 'System')) : 'System';
@endphp

<main id="main" class="main">
  <div class="container-fluid p-2 p-md-4">
    <div class="card shadow-sm">
      <div class="card-header p-3 p-md-4">
        <div class="header-row">
          <div>
            <div class="brand-title">Customer Center</div>
            <div class="subtle">Manage profile, agreements, contracts, invoices, government transactions, installments, and statements</div>
          </div>
          <div class="toolbar">
            <a href="{{ route('crm.index') }}" class="btn btn-outline-secondary btn-sm btn-icon"><i class="fa-solid fa-arrow-left"></i><span>Back</span></a>
            <a href="{{ route('crm.edit', $crm->slug) }}" class="btn btn-primary btn-sm btn-icon"><i class="fa-solid fa-pen-to-square"></i><span>Edit</span></a>
            <form action="{{ route('crm.destroy', $crm->slug) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm btn-icon" onclick="return confirm('Delete this customer?')"><i class="fa-solid fa-trash"></i><span>Delete</span></button>
            </form>
            <button class="btn btn-dark btn-sm btn-icon" onclick="printStatementOnly()"><i class="fa-solid fa-print"></i><span>Print Statement</span></button>
          </div>
        </div>
        <ul class="nav nav-tabs nav-fill mt-3" id="crmTab" role="tablist">
          <li class="nav-item" role="presentation"><button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true"><i class="fa-solid fa-circle-info me-1"></i>Info</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="agreements-tab" data-bs-toggle="tab" data-bs-target="#agreements" type="button" role="tab" aria-controls="agreements" aria-selected="false"><i class="fa-solid fa-file-signature me-1"></i>Agreements</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="contracts-tab" data-bs-toggle="tab" data-bs-target="#contracts" type="button" role="tab" aria-controls="contracts" aria-selected="false"><i class="fa-solid fa-file-contract me-1"></i>Contracts</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab" aria-controls="invoices" aria-selected="false"><i class="fa-solid fa-file-invoice me-1"></i>Invoices</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="govt-tab" data-bs-toggle="tab" data-bs-target="#govt" type="button" role="tab" aria-controls="govt" aria-selected="false"><i class="fa-solid fa-building-columns me-1"></i>Govt Transactions</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="installments-tab" data-bs-toggle="tab" data-bs-target="#installments" type="button" role="tab" aria-controls="installments" aria-selected="false"><i class="fa-solid fa-calendar-check me-1"></i>Installments</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="statement-tab" data-bs-toggle="tab" data-bs-target="#statement" type="button" role="tab" aria-controls="statement" aria-selected="false"><i class="fa-solid fa-list me-1"></i>Statement</button></li>
        </ul>
      </div>

      <div class="card-body p-3 p-md-4">
        <div class="tab-content" id="crmTabContent">
          <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <div class="row g-4">
              <div class="col-12 col-lg-6">
                <div class="section-title">Customer</div>
                <div class="table-container">
                  <table class="table">
                    <tbody>
                      <tr><th class="w-220">Customer ID</th><td class="text-mono">{{ $crm->cl }}</td></tr>
                      <tr><th>Name</th><td>{{ $crm->first_name }} {{ $crm->last_name }}</td></tr>
                      <tr><th>Slug</th><td class="text-mono">{{ $crm->slug }}</td></tr>
                      <tr><th>Address</th><td>{{ $crm->address }}</td></tr>
                      <tr><th>Nationality</th><td>{{ $crm->nationality }}</td></tr>
                      <tr><th>Email</th><td>{{ $crm->email ?? 'N/A' }}</td></tr>
                      <tr><th>Mobile</th><td class="text-mono">{{ $crm->mobile }}</td></tr>
                      <tr><th>Emirates ID</th><td class="text-mono">{{ $crm->emirates_id }}</td></tr>
                      <tr><th>Emergency Contact</th><td>{{ $crm->emergency_contact_person ?? 'N/A' }}</td></tr>
                      <tr><th>Source</th><td>{{ $crm->source ?? 'N/A' }}</td></tr>
                      <tr>
                        <th>Passport Copy</th>
                        <td>
                          <a href="#" class="link-primary doc-preview"
                             data-title="Passport Copy"
                             data-url="{{ asset('storage/' . $crm->passport_copy) }}"
                             data-filename="passport_{{ $crm->cl }}">View Passport Copy</a>
                        </td>
                      </tr>
                      <tr>
                        <th>Emirates ID Copy</th>
                        <td>
                          <a href="#" class="link-primary doc-preview"
                             data-title="Emirates ID Copy"
                             data-url="{{ asset('storage/' . $crm->id_copy) }}"
                             data-filename="id_{{ $crm->cl }}">View ID Copy</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="section-title">Meta</div>
                <div class="summary-grid p-3 rounded-3 border">
                  <div class="label">Date Created</div>
                  <div class="text-mono">{{ $crm->created_at->format('l, F d, Y h:i A') }}</div>
                  <div></div>
                  <div class="label">Last Updated</div>
                  <div class="text-mono">{{ $crm->updated_at->format('l, F d, Y h:i A') }}</div>
                  <div></div>
                  <div class="label">Status</div>
                  <div><span class="badge badge-soft rounded-pill">Active</span></div>
                  <div></div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="agreements" role="tabpanel" aria-labelledby="agreements-tab">
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th class="w-160">Reference No</th>
                    <th>Candidate Name</th>
                    <th class="w-140 text-end">Package</th>
                    <th class="w-140">Start Date</th>
                    <th class="w-140">End Date</th>
                    <th class="w-110">Status</th>
                    <th class="w-140">Created</th>
                    <th class="w-110">View</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($agreements as $agreement)
                    <tr>
                      <td class="text-mono">{{ $agreement->reference_no }}</td>
                      <td>{{ $agreement->candidate_name }}</td>
                      <td class="text-end text-mono">{{ number_format($num($agreement->package),2) }}</td>
                      <td>{{ \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d M Y') }}</td>
                      <td>{{ \Carbon\Carbon::parse($agreement->agreement_end_date)->format('d M Y') }}</td>
                      <td>{{ $agreement->status }}</td>
                      <td>{{ \Carbon\Carbon::parse($agreement->created_at)->format('d M Y') }}</td>
                      <td><a href="{{ route('agreements.show', $agreement->reference_no ?? '') }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                  @empty
                    <tr><td colspan="8" class="text-center py-4 subtle">No agreements available.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <div class="tab-pane fade" id="contracts" role="tabpanel" aria-labelledby="contracts-tab">
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th class="w-160">Contract No</th>
                    <th>Title</th>
                    <th class="w-140">Start Date</th>
                    <th class="w-140">End Date</th>
                    <th class="w-110">Status</th>
                    <th class="w-140">Created</th>
                    <th class="w-110">View</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($contracts as $c)
                    <tr>
                      <td class="text-mono">{{ $c->contract_number }}</td>
                      <td>{{ $c->title }}</td>
                      <td>{{ \Carbon\Carbon::parse($c->start_date)->format('d M Y') }}</td>
                      <td>{{ \Carbon\Carbon::parse($c->end_date)->format('d M Y') }}</td>
                      <td>{{ $c->status }}</td>
                      <td>{{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}</td>
                      <td><a href="{{ route('contracts.show', $c->contract_number ?? '') }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                  @empty
                    <tr><td colspan="7" class="text-center py-4 subtle">No contracts available.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
            <div class="mb-2"><span class="badge bg-light text-dark border">Tax Total: {{ number_format($invTotals['tax_total'],2) }}</span> <span class="badge bg-light text-dark border">Proforma Receipts: {{ number_format($invTotals['proforma_received'],2) }}</span> <span class="badge bg-light text-dark border">Grand Received: {{ number_format($invTotals['grand_received'],2) }}</span></div>
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th class="w-160">Reference No</th>
                    <th class="w-160">Type</th>
                    <th class="w-140 text-end">Total Amount</th>
                    <th class="w-140 text-end">Received Amount</th>
                    <th class="w-140 text-end">Balance</th>
                    <th class="w-110">Status</th>
                    <th class="w-140">Date</th>
                    <th class="w-110">View</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($invoices as $invoice)
                    @php $type = strtolower($invoice->invoice_type ?? $invoice->type ?? '') === 'proforma' ? 'Proforma' : 'Tax'; @endphp
                    <tr>
                      <td class="text-mono">{{ $invoice->invoice_number }}</td>
                      <td>{{ $type }}</td>
                      <td class="text-end text-mono">{{ number_format($num($type==='Tax' ? $invoice->total_amount : 0),2) }}</td>
                      <td class="text-end text-mono">{{ number_format($num($invoice->received_amount),2) }}</td>
                      <td class="text-end text-mono">{{ number_format($num($type==='Tax' ? $invoice->balance_due : 0),2) }}</td>
                      <td>{{ $invoice->status }}</td>
                      <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</td>
                      <td><a href="{{ route('invoices.show', $invoice->invoice_number ?? '') }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                  @empty
                    <tr><td colspan="8" class="text-center py-4 subtle">No invoices available.</td></tr>
                  @endforelse
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2">Totals</td>
                    <td class="text-end text-mono">{{ number_format($invTotals['tax_total'],2) }}</td>
                    <td class="text-end text-mono">{{ number_format($invTotals['grand_received'],2) }}</td>
                    <td class="text-end text-mono">{{ number_format($invTotals['grand_balance'],2) }}</td>
                    <td colspan="3"></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div class="tab-pane fade" id="govt" role="tabpanel" aria-labelledby="govt-tab">
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th class="w-160">Reference No</th>
                    <th>Candidate Name</th>
                    <th class="w-140 text-end">Total Amount</th>
                    <th class="w-140 text-end">Received Amount</th>
                    <th class="w-140 text-end">Balance</th>
                    <th class="w-110">Status</th>
                    <th class="w-140">Date</th>
                    <th class="w-110">View</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($govtTransactions as $transaction)
                    <tr>
                      <td class="text-mono">{{ $transaction->invoice_number }}</td>
                      <td>{{ $transaction->candidate_name }}</td>
                      <td class="text-end text-mono">{{ number_format($num($transaction->total_amount),2) }}</td>
                      <td class="text-end text-mono">{{ number_format($num($transaction->received_amount),2) }}</td>
                      <td class="text-end text-mono">{{ number_format($num($transaction->remaining_amount),2) }}</td>
                      <td>{{ $transaction->status }}</td>
                      <td>{{ \Carbon\Carbon::parse($transaction->invoice_date)->format('d M Y') }}</td>
                      <td><a href="{{ route('govt-transactions.show', $transaction->invoice_number ?? '') }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                  @empty
                    <tr><td colspan="8" class="text-center py-4 subtle">No government transactions available.</td></tr>
                  @endforelse
                </tbody>
                @if($govtTransactions->isNotEmpty())
                  @php
                    $govtTotal=$govtTransactions->sum(fn($g)=>$num($g->total_amount));
                    $govtReceived=$govtTransactions->sum(fn($g)=>$num($g->received_amount));
                    $govtBalance=$govtTransactions->sum(fn($g)=>$num($g->remaining_amount));
                  @endphp
                  <tfoot>
                    <tr>
                      <td colspan="2">Totals</td>
                      <td class="text-end text-mono">{{ number_format($govtTotal,2) }}</td>
                      <td class="text-end text-mono">{{ number_format($govtReceived,2) }}</td>
                      <td class="text-end text-mono">{{ number_format($govtBalance,2) }}</td>
                      <td colspan="3"></td>
                    </tr>
                  </tfoot>
                @endif
              </table>
            </div>
          </div>

          <div class="tab-pane fade printable" id="statement" role="tabpanel" aria-labelledby="statement-tab">
            <form id="statement-filter" class="row g-2 align-items-end mb-3" method="GET" action="{{ route('crm.show', $crm->slug) }}" data-url="{{ route('crm.show', $crm->slug) }}" data-default-from="{{ $periodStart->format('Y-m-d') }}" data-default-to="{{ $periodEnd->format('Y-m-d') }}">
              <div class="col-auto">
                <label class="form-label mb-0">From</label>
                <input type="date" name="from" value="{{ $periodStart->format('Y-m-d') }}" class="form-control form-control-sm">
              </div>
              <div class="col-auto">
                <label class="form-label mb-0">To</label>
                <input type="date" name="to" value="{{ $periodEnd->format('Y-m-d') }}" class="form-control form-control-sm">
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-filter"></i> Apply</button>
                <button type="button" id="reset-statement" class="btn btn-outline-secondary btn-sm">Reset</button>
              </div>
            </form>

            @php
              $printedAt = now()->format('j-M-Y  H:i');
              $debitTotal = 0.0; $creditTotal = 0.0; $running = (float)$openingBalance;
            @endphp

            <div id="statement-area">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                  <div class="brand-title">Customer Statement</div>
                  <div class="subtle">Period: {{ $periodStart->format('j-M-Y') }} – {{ $periodEnd->format('j-M-Y') }}</div>
                  <div class="subtle">Customer: {{ $crm->first_name }} {{ $crm->last_name }}</div>
                  <div class="subtle">Show Balance: Yes</div>
                  <div class="subtle">Currency: Balances in Home Currency</div>
                  <div class="subtle">Suppress Zeros: No</div>
                </div>
                <div class="text-end">
                  <div class="subtle">Printed at: {{ $printedAt }}</div>
                  <div class="subtle">Printed by: {{ $printedBy }}</div>
                </div>
              </div>

              <div class="table-container">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Trans Type</th>
                      <th class="w-160">#</th>
                      <th class="w-140">Date</th>
                      <th>Remarks</th>
                      <th class="w-140 text-end">Debit</th>
                      <th class="w-140 text-end">Credits</th>
                      <th class="w-140 text-end">Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Opening</td>
                      <td class="text-mono">—</td>
                      <td class="text-mono">{{ $periodStart->format('j-M-Y') }}</td>
                      <td>Open Balance</td>
                      <td class="text-end text-mono">{{ number_format(max($running,0),2) }}</td>
                      <td class="text-end text-mono">{{ number_format(max(-$running,0),2) }}</td>
                      <td class="text-end text-mono">{{ number_format($running,2) }}</td>
                    </tr>
                    @foreach($statementEntries as $row)
                      @php
                        $d = (float)($row->debit ?? 0);
                        $c = (float)($row->credit ?? 0);
                        $debitTotal += $d;
                        $creditTotal += $c;
                        $running += ($d - $c);
                      @endphp
                      <tr>
                        <td>{{ $row->type ?? '' }}</td>
                        <td class="text-mono">{{ $row->number ?? '' }}</td>
                        <td class="text-mono">{{ \Carbon\Carbon::parse($row->date)->format('j-M-Y') }}</td>
                        <td>{{ $row->remarks ?? '' }}</td>
                        <td class="text-end text-mono">{{ number_format($d,2) }}</td>
                        <td class="text-end text-mono">{{ number_format($c,2) }}</td>
                        <td class="text-end text-mono">{{ number_format($running,2) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4">Total</td>
                      <td class="text-end text-mono">{{ number_format($debitTotal + max($openingBalance,0),2) }}</td>
                      <td class="text-end text-mono">{{ number_format($creditTotal + max(-$openingBalance,0),2) }}</td>
                      <td class="text-end text-mono">{{ number_format($running,2) }}</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>

<div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="docModalTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-view" id="docViewer"></div>
      <div class="modal-footer justify-content-center">
        <a id="docDownload" href="#" class="btn btn-primary" download><i class="fa-solid fa-download me-1"></i>Download</a>
      </div>
    </div>
  </div>
</div>

@include('../layout.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function printStatementOnly(){
    const tabBtn=document.getElementById('statement-tab');
    if(tabBtn){ new bootstrap.Tab(tabBtn).show(); }
    const node=document.getElementById('statement-area');
    if(!node) return;
    const w=window.open('', '_blank');
    const styles=`:root{--muted:#6b7280;--soft:#f3f4f6;--grad:linear-gradient(to right,#007bff,#00c6ff)}
      html,body{font-size:12px;margin:0;padding:18px 22px;background:#fff;color:#111827;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial}
      .brand-title{font-size:18px;font-weight:800;letter-spacing:.3px;margin-bottom:6px}
      .subtle{color:var(--muted)}
      .table{width:100%;border-collapse:separate;border-spacing:0}
      .table thead th{background-image:var(--grad);color:#fff;text-transform:uppercase;letter-spacing:.02em;font-size:12px;padding:.7rem .85rem}
      .table tbody td,.table tfoot td{padding:.6rem .85rem;font-size:12px;vertical-align:middle}
      .table tbody tr:nth-of-type(odd){background:var(--soft)}
      .table tfoot td{font-weight:700;background-image:var(--grad);color:#fff;border-top:0}
      .text-mono{font-variant-numeric:tabular-nums;font-feature-settings:"tnum"}`;
    w.document.write(`<!doctype html><html><head><meta charset="utf-8"><title>Customer Statement</title><style>${styles}</style></head><body>${node.outerHTML}</body></html>`);
    w.document.close(); w.focus(); setTimeout(()=>{w.print(); w.close();},200);
  }

  const filterForm = document.getElementById('statement-filter');
  const resetBtn = document.getElementById('reset-statement');

  function fetchStatement(url){
    fetch(url,{headers:{'X-Requested-With':'XMLHttpRequest'}})
      .then(r=>r.text())
      .then(html=>{
        const p=new DOMParser().parseFromString(html,'text/html');
        const next=p.getElementById('statement-area');
        const cur=document.getElementById('statement-area');
        if(next && cur){ cur.replaceWith(next); }
        const tabBtn=document.getElementById('statement-tab');
        if(tabBtn){ new bootstrap.Tab(tabBtn).show(); }
      });
  }

  if(filterForm){
    filterForm.addEventListener('submit',function(e){
      e.preventDefault();
      const base=this.dataset.url;
      const from=this.querySelector('input[name="from"]').value;
      const to=this.querySelector('input[name="to"]').value;
      const qs=new URLSearchParams();
      if(from) qs.set('from',from);
      if(to) qs.set('to',to);
      fetchStatement(base+(qs.toString()?('?'+qs.toString()):''));
    });
  }

  if(resetBtn && filterForm){
    resetBtn.addEventListener('click',function(){
      const base=filterForm.dataset.url;
      const defFrom=filterForm.dataset.defaultFrom;
      const defTo=filterForm.dataset.defaultTo;
      filterForm.querySelector('input[name="from"]').value=defFrom;
      filterForm.querySelector('input[name="to"]').value=defTo;
      fetchStatement(base);
    });
  }

  document.querySelectorAll('.doc-preview').forEach(function(el){
    el.addEventListener('click',function(e){
      e.preventDefault();
      const title=this.dataset.title||'Document';
      const url=this.dataset.url||'#';
      const filename=this.dataset.filename||'document';
      const modalEl=document.getElementById('docModal');
      const titleEl=document.getElementById('docModalTitle');
      const viewer=document.getElementById('docViewer');
      const dl=document.getElementById('docDownload');
      titleEl.textContent=title;
      viewer.innerHTML='';
      const ext=url.split('?')[0].split('.').pop().toLowerCase();
      let node;
      if(['pdf'].includes(ext)){
        node=document.createElement('iframe');
        node.src=url; node.style.width='100%'; node.style.height='70vh'; node.setAttribute('frameborder','0');
      }else if(['jpg','jpeg','png','gif','webp','bmp','svg'].includes(ext)){
        node=document.createElement('img');
        node.src=url; node.className='img-fluid';
      }else{
        node=document.createElement('iframe');
        node.src=url; node.style.width='100%'; node.style.height='70vh'; node.setAttribute('frameborder','0');
      }
      viewer.appendChild(node);
      dl.href=url; dl.setAttribute('download', filename);
      new bootstrap.Modal(modalEl).show();
    });
  });
</script>
