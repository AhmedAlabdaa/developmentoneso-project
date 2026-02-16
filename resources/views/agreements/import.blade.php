
<div class="container mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">Import Agreements CSV</h1>

  @if(session('status'))
    <div class="mb-6 p-5 bg-green-50 border-l-4 border-green-400 rounded">
      <p class="font-semibold text-green-800">{{ session('status') }}</p>
      <div class="mt-3 space-y-1 text-green-700">
        <p><span class="font-medium">Agreements created:</span> {{ session('agreements_created', 0) }}</p>
        <p><span class="font-medium">Installments created:</span> {{ session('installments_created', 0) }}</p>
        <p><span class="font-medium">Contracts created:</span> {{ session('contracts_created', 0) }}</p>
        <p><span class="font-medium">Row errors:</span> {{ session('row_failures_count', 0) }}</p>
      </div>
      @if(session('rowErrors'))
        <details class="mt-4">
          <summary class="cursor-pointer text-blue-600 font-medium">View row-level errors</summary>
          <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-gray-700">
            @foreach(session('rowErrors') as $err)
              <li>Row {{ $err['row'] }}: {{ $err['error'] }}</li>
            @endforeach
          </ul>
        </details>
      @endif
    </div>
  @endif

  @if($errors->any())
    <div class="mb-6 p-5 bg-red-50 border-l-4 border-red-400 rounded">
      <ul class="list-disc list-inside space-y-1 text-red-700">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('agreements.import') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    <div>
      <label for="file" class="block mb-1 font-medium text-gray-700">CSV File</label>
      <input
        type="file"
        name="file"
        id="file"
        accept=".csv"
        required
        class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
      >
    </div>
    <button
      type="submit"
      class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded"
    >
      Upload & Import
    </button>
  </form>
</div>
