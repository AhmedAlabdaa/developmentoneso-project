@include('role_header')

<main id="main" class="main">
    <div class="pagetitle"><h1>Posting Errors</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Source</th>
                                <th>Table</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                                <tr>
                                    <td>{{ $r->created_at }}</td>
                                    <td>{{ $r->source_type }}</td>
                                    <td>{{ $r->table_name }}</td>
                                    <td>{{ $r->message }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No errors</td></tr>
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
