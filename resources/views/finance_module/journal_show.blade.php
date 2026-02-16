@include('role_header')

<main id="main" class="main">
    <div class="pagetitle mt-4">
        <h1>Journal Entry Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
                <li class="breadcrumb-item"><a href="{{ route('finance.journals') }}">Journals</a></li>
                <li class="breadcrumb-item active">Entry #{{ $journal->journal_id }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary me-2">#{{ $journal->journal_id }}</span>
                            <span class="fw-bold">{{ $journal->journal_date }}</span>
                        </div>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="text-muted small">Reference</label>
                                <div class="fw-bold">{{ $journal->reference_no ?? '-' }}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Source</label>
                                <div>{{ str_replace('App\Models\\', '', $journal->source_type ?? 'Manual') }}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Note</label>
                                <div class="text-muted fst-italic">{{ $journal->memo ?? $journal->note ?? '-' }}</div>
                            </div>
                        </div>


                        <!-- Added Source Details Section -->
                        @if($journal->source || $journal->preSrc)
                        <div class="row mb-4 p-3 bg-light rounded mx-1 border">

                            @if($journal->source)
                                <div class="col-md-4">
                                    <label class="text-muted small">Transaction Serial</label>
                                    <div class="fw-bold">{{ $journal->source->serial_no ?? '-' }}</div>
                                </div>
                            @endif
                            @if($journal->preSrc)
                                <div class="col-md-4">
                                    <label class="text-muted small">Service / Pre-Source</label>
                                    <div>{{ $journal->preSrc->name ?? '-' }}</div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <label class="text-muted small">Created By</label>
                                <div><span class="badge bg-secondary">{{ ($journal->creator->first_name ?? '') . ' ' . ($journal->creator->last_name ?? '') ?: ($journal->created_by ?? '-') }}</span></div>
                            </div>
                        </div>
                        @endif

                        <h5 class="card-title py-0">Transaction Lines</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ledger Account</th>
                                        <th>Subclass</th>
                                        <th>Note / Description</th>
                                        <th class="text-end">Debit</th>
                                        <th class="text-end">Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalDebit = 0;
                                        $totalCredit = 0;
                                    @endphp
                                    @foreach($lines as $line)
                                    @php
                                        $debit = $line->debit ?? 0;
                                        $credit = $line->credit ?? 0;
                                        $totalDebit += $debit;
                                        $totalCredit += $credit;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $line->ledger_name ?? $line->ledger->name ?? '-' }}</span>
                                            @if(!empty($line->candidate_name))
                                                <div class="small text-muted"><i class="fa-solid fa-user-tag me-1"></i> {{ $line->candidate_name }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $line->ledger->sub_class?->label() ?? '-' }}</td>
                                        <td>{{ $line->line_note ?? $line->note ?? '-' }}</td>
                                        <td class="text-end text-danger-custom fw-bold">{{ $debit > 0 ? number_format($debit, 2) : '-' }}</td>
                                        <td class="text-end text-success-custom fw-bold">{{ $credit > 0 ? number_format($credit, 2) : '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light fw-bold">
                                        <td colspan="3" class="text-end">Totals:</td>
                                        <td class="text-end">{{ number_format($totalDebit, 2) }}</td>
                                        <td class="text-end">{{ number_format($totalCredit, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .text-danger-custom { color: #dc3545; }
    .text-success-custom { color: #198754; }
</style>

@include('../layout.footer')
