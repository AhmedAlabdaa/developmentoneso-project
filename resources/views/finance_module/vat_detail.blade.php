@include('role_header')

<main id="main" class="main">
    <div class="pagetitle"><h1>VAT Detail</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="{{ route('finance.vatDetail') }}">
                    <div class="col-md-3"><input type="date" name="from" class="form-control" value="{{ request('from') }}"></div>
                    <div class="col-md-3"><input type="date" name="to" class="form-control" value="{{ request('to') }}"></div>
                    <div class="col-md-4"><input type="text" name="ref" class="form-control" placeholder="Invoice ref..." value="{{ request('ref') }}"></div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Filter</button>
                        <a class="btn btn-outline-secondary w-100" href="{{ route('finance.vatDetail') }}">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Ref</th>
                                <th class="text-end">Net</th>
                                <th class="text-end">VAT</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                                <tr>
                                    <td>{{ $r->journal_date }}</td>
                                    <td>{{ $r->reference_no }}</td>
                                    <td class="text-end">{{ number_format($r->net_amount,2) }}</td>
                                    <td class="text-end">{{ number_format($r->vat_amount,2) }}</td>
                                    <td class="text-end">{{ number_format($r->total_amount,2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No records</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $rows->links('vendor.pagination.bootstrap-4') }}

            </div>
        </div>
    </section>
</main>

@include('../layout.footer')
