@include('role_header')

<main id="main" class="main">
    <div class="pagetitle"><h1>Journal Entries</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="{{ route('finance.journals') }}">
                    <div class="col-md-2">
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="source_type">
                            <option value="">All Sources</option>
                            @foreach(['TAX_INVOICE','TAX_RECEIPT','TAX_INVOICE_REV'] as $s)
                                <option value="{{ $s }}" @selected(request('source_type')==$s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="ref" class="form-control" placeholder="Reference..." value="{{ request('ref') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Filter</button>
                        <a class="btn btn-outline-secondary w-100" href="{{ route('finance.journals') }}">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Source</th>
                                <th>Ref</th>
                                <th>Memo</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Credit</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($journals as $j)
                                <tr>
                                    <td>{{ $j->journal_date }}</td>
                                    <td>{{ $j->source_type }}</td>
                                    <td>{{ $j->reference_no }}</td>
                                    <td>{{ $j->memo }}</td>
                                    <td class="text-end">{{ number_format($j->total_debit,2) }}</td>
                                    <td class="text-end">{{ number_format($j->total_credit,2) }}</td>
                                    <td>{{ $j->status }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-primary" href="{{ route('finance.journals.show',$j->journal_id) }}">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-4">No records</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-2">
                    {{ $journals->links('vendor.pagination.bootstrap-4') }}
                </div>

            </div>
        </div>
    </section>
</main>

@include('../layout.footer')
