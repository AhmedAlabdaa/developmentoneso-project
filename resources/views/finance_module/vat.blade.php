@include('role_header')

<main id="main" class="main">
    <div class="pagetitle"><h1>VAT Report</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="d-flex gap-2 mt-2">
                    <a class="btn btn-primary" href="{{ route('finance.vatDetail') }}">VAT Detail</a>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Period</th>
                                <th class="text-end">VAT Output</th>
                                <th class="text-end">Revenue</th>
                                <th class="text-end">Invoices</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                                <tr>
                                    <td>{{ $r->period }}</td>
                                    <td class="text-end">{{ number_format($r->vat_output,2) }}</td>
                                    <td class="text-end">{{ number_format($r->revenue,2) }}</td>
                                    <td class="text-end">{{ $r->invoices }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No records</td></tr>
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
