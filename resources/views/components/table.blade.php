<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach($headers as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
                <th colspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($rows as $row)
                <tr>
                    {{-- Dynamically populate rows based on header count --}}
                    @foreach($row as $cell)
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $cell }}
                        </td>
                    @endforeach
                    {{-- <td class="px-6 py-4 whitespace-nowrap"><button>Update</button></td> --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="/engine/{{ $row[1] }}/edit" class="text-blue-600 hover:text-blue-800">
                            Update
                        </a>
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap"><Button>Delete</Button></td> --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="/delete/{{ $row[1] }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="text-center py-4">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
