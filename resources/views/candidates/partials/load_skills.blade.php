<table class="table table-bordered text-center">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">Skill Name</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        @if ($skills->count() > 0)
            @foreach ($skills as $skill)
                <tr>
                    <td>{{ $skill->skill_name ?? 'N/A' }}</td>
                    <td>{{ $skill->skill_description ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2" class="text-center">No skills found.</td>
            </tr>
        @endif
    </tbody>
</table>
