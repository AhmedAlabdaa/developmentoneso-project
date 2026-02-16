@include('role_header')

<main id="main" class="main">
    <div class="pagetitle"><h1>Customer Ledger</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="{{ route('finance.customerLedger') }}">
                    <div class="col-md-3"><input type="date" name="from" class="form-control" value="{{ request('from') }}"></div>
                    <div class="col-md-3"><input type="date" name="to" class="form-control" value="{{ request('to') }}"></div>
                    <div class="col-md-4">
                        <select name="crm_customer_id" class="form-select">
                            <option value="">All Customers</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->crm_customer_id }}" @selected(request('crm_customer_id')==$c->crm_customer_id)>{{ $c->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Filter</button>
                        <a class="btn btn-outline-secondary w-100" href="{{ route('finance.customerLedger') }}">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>CL #</th>
                                <th>Date</th>
                                <th>Source</th>
                                <th>Ref</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Credit</th>
                                <th class="text-end">Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                                <tr>
                                    <td>{{ $r->customer_name }}</td>
                                    <td>{{ $r->cl_number }}</td>
                                    <td>{{ $r->journal_date }}</td>
                                    <td>{{ $r->source_type }}</td>
                                    <td>{{ $r->reference_no }}</td>
                                    <td class="text-end">{{ number_format($r->debit,2) }}</td>
                                    <td class="text-end">{{ number_format($r->credit,2) }}</td>
                                    <td class="text-end">{{ number_format($r->balance_change,2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-4">No records</td></tr>
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
