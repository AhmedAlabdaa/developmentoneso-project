<table class="table table-bordered text-center">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">Country Name</th>
            <th scope="col">Arabic Name</th>
            <th scope="col">FRA Name</th>
        </tr>
    </thead>
    <tbody>
        @if ($desiredCountries->count() > 0)
            @foreach ($desiredCountries as $country)
                <tr>
                    <td>{{ $country->country_name ?? 'N/A' }}</td>
                    <td>{{ $country->country_arabic_name ?? 'N/A' }}</td>
                    <td>{{ $country->fra_name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">No desired countries found.</td>
            </tr>
        @endif
    </tbody>
</table>
