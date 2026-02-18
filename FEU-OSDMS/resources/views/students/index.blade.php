<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">Student Directory</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="GET" action="{{ route('students.index') }}" class="mb-6">
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Search by ID Number or Name..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                        <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-800">
                            Search
                        </button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4 font-bold text-gray-600">ID Number</th>
                                <th class="p-4 font-bold text-gray-600">Name</th>
                                <th class="p-4 font-bold text-gray-600">Program</th>
                                <th class="p-4 font-bold text-gray-600 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 font-mono text-sm">{{ $student->id_number }}</td>
                                    <td class="p-4 font-semibold">{{ $student->name }}</td>
                                    <td class="p-4 text-sm">{{ $student->program_code ?? 'N/A' }}</td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:underline font-bold text-sm">
                                            View Profile →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-400 italic">No students found matching your search.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $students->appends(['search' => $search])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let timeout = null;
    const searchInput = document.querySelector('input[name="search"]');
    const searchForm = searchInput.closest('form');

    searchInput.addEventListener('keyup', function() {
        clearTimeout(timeout);
        
        // Wait 500ms after typing stops to avoid spamming the server
        timeout = setTimeout(() => {
            searchForm.submit();
        }, 500);
    });

    // Keep the cursor at the end of the text after the page reloads
    const val = searchInput.value;
    searchInput.value = '';
    searchInput.focus();
    searchInput.value = val;
</script>