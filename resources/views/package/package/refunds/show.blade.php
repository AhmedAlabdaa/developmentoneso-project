@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<style>
  :root{--c-primary:#0d6efd;--c-muted:#6c757d;--pad:1rem;--gap:.75rem;--radius:.6rem;--bg-soft:#f7f9fc;--row-alt:#f2f6ff}
  .wrap{max-width:1100px;margin:0 auto;padding:var(--pad)}
  .card{border:1px solid #e5e8ef;border-radius:var(--radius);background:#fff}
  .card + .card{margin-top:var(--pad)}
  .card-hdr{display:flex;align-items:center;justify-content:space-between;padding:calc(var(--pad) - .25rem) var(--pad) var(--gap) var(--pad)}
  .title{margin:0;font-size:1.15rem;font-weight:700;letter-spacing:.2px}
  .sub{color:var(--c-muted);font-size:.85rem}
  .btn-row{display:flex;gap:.5rem}
  .divider{height:1px;background:#edf0f5;margin:0 var(--pad)}
  .band{display:grid;grid-template-columns:repeat(4,1fr);gap:var(--gap);padding:var(--pad)}
  .band .item{background:var(--bg-soft);border:1px solid #ecf1f6;border-radius:.5rem;padding:.65rem .75rem}
  .item .lbl{display:block;color:var(--c-muted);font-size:.78rem;margin-bottom:.15rem}
  .item .val{font-weight:700}
  .sect-h{padding:calc(var(--pad) - .25rem) var(--pad) .25rem var(--pad);font-weight:700;color:#12263f}
  .kv{width:100%;border-collapse:separate;border-spacing:0;table-layout:fixed;margin:0;padding:0}
  .kv tbody tr:nth-child(odd){background:#fff}
  .kv tbody tr:nth-child(even){background:var(--row-alt)}
  .kv th,.kv td{padding:.65rem .8rem;border:1px solid #e9edf3}
  .kv th{width:26%;background:#f9fbfe;color:#334155;font-weight:600}
  .kv td{width:24%;font-weight:700;color:#111827}
  .money{font-variant-numeric:tabular-nums}
  .chip{display:inline-block;padding:.25rem .6rem;border-radius:999px;border:1px solid #e6eaf2;background:#f6f8fb;font-weight:600;font-size:.85rem}
  .b-type{background:#e8f2ff;border-color:#d7e7ff;color:#0b5ed7}
  .b-pending{background:#fff3cd;border-color:#ffe8a1;color:#7a5c00}
  .b-approved{background:#d1e7dd;border-color:#bcd9cd;color:#0f5132}
  .b-rejected{background:#f8d7da;border-color:#f1b0b7;color:#842029}
  .files thead th{background:var(--c-primary);color:#fff;text-transform:uppercase;font-size:.78rem;letter-spacing:.03em}
  .files td,.files th{padding:.65rem .75rem;border:1px solid #e9edf3;vertical-align:middle}
  .files .file-btn{white-space:nowrap}
  .thumb{display:inline-block;max-height:64px;max-width:120px;border:1px solid #e5e8ef;border-radius:.35rem;margin-left:.5rem}
  @media (max-width: 992px){.band{grid-template-columns:repeat(2,1fr)}.btn-row{flex-wrap:wrap}}
  @media (max-width: 576px){.wrap{padding:.75rem}.band{grid-template-columns:1fr}.kv th{width:40%}.kv td{width:60%}}
</style>

@php
  $tz='Asia/Qatar';
  $fmt   = fn($d,$f='d M Y') => $d ? \Carbon\Carbon::parse($d)->timezone($tz)->format($f) : '-';
  $fmtDT = fn($d) => $d ? \Carbon\Carbon::parse($d)->timezone($tz)->format('d M Y h:i A') : '-';
  $money = fn($n) => isset($n) ? number_format((float)$n,2) : '-';
  $typeBadge = $refund->action_type === 'refund' ? 'b-type' : 'b-pending';
  $statusBadge = match($refund->status){'approved'=>'b-approved','rejected'=>'b-rejected',default=>'b-pending'};
  $dueDate = $refund->action_type === 'refund' ? $refund->refund_due_date : $refund->replacement_due_date;
  $reason  = $refund->action_type === 'refund' ? $refund->refund_reason : $refund->replacement_reason;
  $finalBalance = $refund->action_type === 'refund' ? $refund->refund_final_balance : $refund->replacement_final_balance;
  $bankAmount   = $refund->action_type === 'refund' ? $refund->refund_bank_amount : $refund->replacement_bank_amount;

  $fileUrl = function (?string $path) {
    if (!$path) return null;
    $clean = trim($path, '/');
    $clean = preg_replace('#^storage/app/public/#', '', $clean);
    $clean = preg_replace('#^app/public/#', '', $clean);
    $clean = preg_replace('#^public/#', '', $clean);
    return url('storage/app/public/'.$clean);
  };
  $isImage = function (?string $path) {
    if (!$path) return false;
    return (bool) preg_match('/\.(jpe?g|png|gif|webp|bmp)$/i', $path);
  };
@endphp
<main id="main" class="main">
  <section class="section">
    <div class="wrap">
      <div class="card">
        <div class="card-hdr">
          <div>
            <h5 class="title">
              {{ strtoupper($refund->candidate_name ?? '-') }}
              <span class="chip {{$typeBadge}} ms-2">{{ strtoupper($refund->action_type) }}</span>
              <span class="chip {{$statusBadge}} ms-1 text-uppercase">{{ $refund->status ?? 'pending' }}</span>
            </h5>
            <div class="sub">CN: {{ $refund->cn_number ?? '-' }}</div>
          </div>
          <div class="btn-row">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Back</a>
            <a href="{{ route('refunds.edit', ['refund' => $refund->id]) }}" class="btn btn-primary"><i class="fa-solid fa-pen me-1"></i>Edit</a>
          </div>
        </div>
        <div class="divider"></div>
        <div class="band">
          <div class="item"><span class="lbl">Created</span><span class="val">{{ $fmtDT($refund->created_at) }}</span></div>
          <div class="item"><span class="lbl">Due Date</span><span class="val">{{ $fmt($dueDate) }}</span></div>
          <div class="item"><span class="lbl">Return Date</span><span class="val">{{ $fmt($refund->return_date) }}</span></div>
          <div class="item"><span class="lbl">Stage</span><span class="val">{{ $refund->refund_stage ?? '-' }}</span></div>
        </div>
      </div>
      <div class="card">
        <div class="sect-h"><i class="fa-solid fa-user me-1 text-primary"></i> Profile</div>
        <table class="kv">
          <tbody>
            <tr><th>Candidate</th><td>{{ $refund->candidate_name ?? '-' }}</td><th>Sponsor</th><td>{{ $refund->client_name ?? '-' }}</td></tr>
            <tr><th>Nationality</th><td>{{ $refund->nationality ?? '-' }}</td><th>Reason</th><td>{{ $reason ?: '-' }}</td></tr>
            <tr><th>Contract Start</th><td>{{ $fmt($refund->contract_start_date) }}</td><th>Contract End</th><td>{{ $fmt($refund->contract_end_date) }}</td></tr>
            <tr><th>Total Days</th><td>{{ $refund->number_of_days ?? '-' }}</td><th>Worked Days</th><td>{{ $refund->maid_worked_days ?? '-' }}</td></tr>
            <tr><th>Salary Type</th><td>{{ $refund->worker_salary_type ?? '-' }}</td><th>Salary Amount</th><td class="money">{{ $money($refund->worker_salary_amount) }}</td></tr>
          </tbody>
        </table>
      </div>
      <div class="card">
        <div class="sect-h"><i class="fa-solid fa-coins me-1 text-primary"></i> Financials</div>
        <table class="kv">
          <tbody>
            <tr><th>Contracted</th><td class="money">{{ $money($refund->contracted_amount) }}</td><th>Final Balance</th><td class="money">{{ $money($finalBalance) }}</td></tr>
            <tr><th>Refund Balance</th><td class="money">{{ $money($refund->refund_balance) }}</td><th>Replacement Balance</th><td class="money">{{ $money($refund->replacement_balance) }}</td></tr>
            <tr><th>Bank Amount</th><td class="money">{{ $money($bankAmount) }}</td><th>Payment Method</th><td>{{ $refund->payment_method ?? '-' }}</td></tr>
            <tr><th>Paid Amount</th><td class="money">{{ $money($refund->paid_amount) }}</td><th>Paid At</th><td>{{ $fmtDT($refund->paid_at) }}</td></tr>
            <tr><th>Payment Ref</th><td>{{ $refund->payment_reference ?? '-' }}</td><th></th><td></td></tr>
          </tbody>
        </table>
      </div>

      <div class="card">
        <div class="sect-h"><i class="fa-solid fa-clipboard-check me-1 text-primary"></i> Approvals & NOC</div>
        <table class="kv">
          <tbody>
            <tr><th>Approved By</th><td>{{ $refund->approved_by ?? '-' }}</td><th>Approved At</th><td>{{ $fmtDT($refund->approved_at) }}</td></tr>
            <tr><th>Approved Note</th><td colspan="3">{{ $refund->approved_note ?? '-' }}</td></tr>
            <tr><th>NOC Status</th><td><span class="chip">{{ $refund->noc_status ?? '-' }}</span></td><th>NOC Expiry</th><td>{{ $fmt($refund->noc_expiry_date) }}</td></tr>
            <tr><th>Penalty Expiry</th><td>{{ $fmt($refund->penalty_expiry_date) }}</td><th>Penalty Type</th><td>{{ $refund->penalty_type ?? '-' }}</td></tr>
            <tr><th>Penalty Days</th><td>{{ $refund->penalty_days ?? '-' }}</td><th>Penalty Rate</th><td class="money">{{ $money($refund->penalty_rate) }}</td></tr>
            <tr><th>Penalty Amount</th><td class="money">{{ $money($refund->penalty_amount) }}</td><th>Salary Deduction</th><td class="money">{{ $money($refund->salary_deduction_amount) }}</td></tr>
          </tbody>
        </table>
      </div>
      <div class="card">
        <div class="sect-h"><i class="fa-solid fa-paperclip me-1 text-primary"></i> Attachments</div>
        <table class="table files">
          <thead>
            <tr><th style="width:35%">Type</th><th>Preview / Link</th><th style="width:22%">Status</th></tr>
          </thead>
          <tbody>
            <tr>
              <td>Bank Proof</td>
              <td>
                @php $u = $fileUrl($refund->bank_proof_path); @endphp
                @if($u)
                  <a target="_blank" class="btn btn-sm btn-outline-primary file-btn" href="{{ $u }}"><i class="fa-solid fa-file-invoice-dollar me-1"></i>Open</a>
                  @if($isImage($refund->bank_proof_path)) <img src="{{ $u }}" alt="Bank Proof" class="thumb"> @endif
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td><span class="chip">{{ $refund->bank_proof_path ? 'Available' : 'Missing' }}</span></td>
            </tr>
            <tr>
              <td>General Proof</td>
              <td>
                @php $u = $fileUrl($refund->proof_path); @endphp
                @if($u)
                  <a target="_blank" class="btn btn-sm btn-outline-primary file-btn" href="{{ $u }}"><i class="fa-solid fa-file-lines me-1"></i>Open</a>
                  @if($isImage($refund->proof_path)) <img src="{{ $u }}" alt="Proof" class="thumb"> @endif
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td><span class="chip">{{ $refund->proof_path ? 'Available' : 'Missing' }}</span></td>
            </tr>
            <tr>
              <td>Penalty Payment Proof</td>
              <td>
                @php $u = $fileUrl($refund->penalty_payment_proof_path); @endphp
                @if($u)
                  <a target="_blank" class="btn btn-sm btn-outline-primary file-btn" href="{{ $u }}"><i class="fa-solid fa-file-circle-check me-1"></i>Open</a>
                  @if($isImage($refund->penalty_payment_proof_path)) <img src="{{ $u }}" alt="Penalty Proof" class="thumb"> @endif
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td><span class="chip">{{ $refund->penalty_payment_proof_path ? 'Available' : 'Missing' }}</span></td>
            </tr>
            <tr>
              <td>Istiraha Proof</td>
              <td>
                @php $u = $fileUrl($refund->istiraha_proof_path); @endphp
                @if($u)
                  <a target="_blank" class="btn btn-sm btn-outline-primary file-btn" href="{{ $u }}"><i class="fa-solid fa-file me-1"></i>Open</a>
                  @if($isImage($refund->istiraha_proof_path)) <img src="{{ $u }}" alt="Istiraha Proof" class="thumb"> @endif
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td><span class="chip">{{ $refund->istiraha_proof_path ? 'Available' : 'Missing' }}</span></td>
            </tr>
            <tr>
              <td>Payment Proof</td>
              <td>
                @php $u = $fileUrl($refund->payment_proof_path); @endphp
                @if($u)
                  <a target="_blank" class="btn btn-sm btn-outline-primary file-btn" href="{{ $u }}"><i class="fa-solid fa-file-invoice me-1"></i>Open</a>
                  @if($isImage($refund->payment_proof_path)) <img src="{{ $u }}" alt="Payment Proof" class="thumb"> @endif
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td><span class="chip">{{ $refund->payment_proof_path ? 'Available' : 'Missing' }}</span></td>
            </tr>
            <tr>
              <td>Original Passport</td>
              <td><span class="chip">{{ $refund->original_passport ?: '-' }}</span></td>
              <td></td>
            </tr>
            <tr>
              <td>Worker Belongings</td>
              <td><span class="chip">{{ $refund->worker_belongings ?: '-' }}</span></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>
@include('../layout.footer')
