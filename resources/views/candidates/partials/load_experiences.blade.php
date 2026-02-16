<table class="table table-bordered text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Country</th>
            <th scope="col">Experience (Years)</th>
            <th scope="col">Experience (Months)</th>
        </tr>
    </thead>
    <tbody>
        @if ($candidate->experiences->count() > 0)
            @foreach ($candidate->experiences as $experience)
                <tr>
                    <td>{{ $experience->country ?? 'N/A' }}</td>
                    <td>{{ $experience->experience_years ?? '0' }}</td>
                    <td>{{ $experience->experience_months ?? '0' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">No experiences found.</td>
            </tr>
        @endif
    </tbody>
</table>
