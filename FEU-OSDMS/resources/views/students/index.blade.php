<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">👥 Student Directory</h2>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <!-- Search Section -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <form method="GET" action="{{ route('students.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="🔍 Search by ID or Name..."
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 focus:outline-none">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold transition">
                        Search
                    </button>
                </form>
            </div>

            <!-- Students Table/Cards -->
            @if($students->count() > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-sm text-gray-600">
                        Found <span class="font-bold text-green-600">{{ $students->count() }}</span> student(s)
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="p-4 text-left font-bold text-gray-600 text-xs uppercase">🆔 ID Number</th>
                                <th class="p-4 text-left font-bold text-gray-600 text-xs uppercase">👤 Name</th>
                                <th class="p-4 text-left font-bold text-gray-600 text-xs uppercase">📚 Program</th>
                                <th class="p-4 text-left font-bold text-gray-600 text-xs uppercase">🏫 Campus</th>
                                <th class="p-4 text-center font-bold text-gray-600 text-xs uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $student)
                                <tr class="hover:bg-green-50 transition">
                                    <td class="p-4 font-mono text-gray-800">{{ $student->id_number }}</td>
                                    <td class="p-4 font-semibold text-gray-800">{{ $student->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $student->program_code ?? '—' }}</td>
                                    <td class="p-4 text-gray-600">{{ $student->campus ?? 'Manila' }}</td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('students.show', $student->id) }}"
                                           class="inline-block px-3 py-1 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-lg text-xs font-bold transition">
                                            View Profile
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($students instanceof \Illuminate\Pagination\Paginator)
                <div class="p-6 border-t border-gray-100">
                    {{ $students->appends(['search' => $search ?? ''])->links() }}
                </div>
                @endif
            </div>
            @else
            <div class="bg-white rounded-lg shadow-sm text-center py-16">
                <p class="text-4xl mb-4">🔍</p>
                <p class="text-lg font-semibold text-gray-700 mb-2">No Students Found</p>
                <p class="text-gray-500">
                    @if($search)
                        Try adjusting your search term for "{{ $search }}"
                    @else
                        No students are currently registered in the system.
                    @endif
                </p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    let timeout = null;
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                searchInput.closest('form').submit();
            }, 500);
        });
    }
</script>
