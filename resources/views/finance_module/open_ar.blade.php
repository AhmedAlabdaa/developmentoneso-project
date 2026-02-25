@include('role_header')

<main id="main" class="main">
    <div class="pagetitle"><h1>Open AR</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="{{ route('finance.openAr') }}">
                    <div class="col-md-6"><input type="text" name="customer" class="form-control" placeholder="Customer name..." value="{{ request('customer') }}"></div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Search</button>
                        <a class="btn btn-outline-secondary w-100" href="{{ route('finance.openAr') }}">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>CL #</th>
                                <th class="text-end">Invoiced</th>
                                <th class="text-end">Received</th>
                                <th class="text-end">Open</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                                <tr>
                                    <td>{{ $r->customer_name }}</td>
                                    <td>{{ $r->cl_number }}</td>
                                    <td class="text-end">{{ number_format($r->total_invoiced,2) }}</td>
                                    <td class="text-end">{{ number_format($r->total_received,2) }}</td>
                                    <td class="text-end">{{ number_format($r->open_balance,2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No open balances</td></tr>
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
