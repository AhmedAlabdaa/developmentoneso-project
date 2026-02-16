<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Reference&nbsp;#</th>
                <th>Payroll&nbsp;Type</th>
                <th>Payroll Period</th>
                <th>No. of Candidates</th>
                <th>Total&nbsp;Amount</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($payrolls as $payroll)
                <tr>
                    <td>
                        <a href="{{ route('payrolls.payroll-sheet', $payroll->reference_no) }}" class="text-decoration-none">
                            {{ $payroll->reference_no }}
                        </a>
                    </td>

                    <td>{{ $payroll->type ?? 'N/A' }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($payroll->pay_period_start)->format('d M Y') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($payroll->pay_period_end)->format('d M Y') }}
                    </td>

                    <td>{{ $payroll->number_of_candidates }}</td>

                    <td>{{ number_format($payroll->total_amount, 2) }}</td>

                    <td class="text-center">
                        <a  href="{{ route('payrolls.payroll-sheet', $payroll->reference_no) }}"
                            class="btn btn-info btn-icon-only"  title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No payroll records found.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th>Reference&nbsp;#</th>
                <th>Payroll&nbsp;Type</th>
                <th>Payroll Period</th>
                <th>No. of Candidates</th>
                <th>Total&nbsp;Amount</th>
                <th class="text-center">Action</th>
            </tr>
        </tfoot>
    </table>
</div>

@if ($payrolls->hasPages())
    <nav aria-label="Pagination">
        <div class="pagination-container">
            <span class="muted-text">
                Showing {{ $payrolls->firstItem() }}-{{ $payrolls->lastItem() }} of {{ $payrolls->total() }}
            </span>

            <ul class="pagination justify-content-center">
                {{ $payrolls->appends(request()->except('page'))
                             ->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </div>
    </nav>
@endif
