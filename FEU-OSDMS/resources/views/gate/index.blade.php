<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">🚪 Gate Entry Log</h2>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-6">

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg font-semibold flex items-center">
                    <span class="mr-2">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Entry Form Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                <div class="flex items-center mb-4">
                    <span class="text-2xl mr-2">📝</span>
                    <h3 class="font-bold text-lg text-gray-800">Log New Student Entry</h3>
                </div>
                <form action="{{ route('gate.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Student ID Number</label>
                            <input type="text" name="id_number" placeholder="e.g., 202312345" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-yellow-500 focus:ring-yellow-500 focus:outline-none" value="{{ old('id_number') }}">
                            @error('id_number')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Entry Reason</label>
                            <select name="reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-yellow-500 focus:ring-yellow-500 focus:outline-none">
                                <option value="Forgot ID">Forgot ID</option>
                                <option value="Lost ID">Lost ID</option>
                                <option value="Damaged ID">Damaged ID</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 rounded-lg transition uppercase text-sm">
                                Record Entry
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Entry Logs Table -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <span class="text-2xl mr-2">📊</span>
                        <h3 class="font-bold text-lg text-gray-800">Today's Entry Logs</h3>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold">{{ $entries->count() }} entries</span>
                </div>

                <div class="overflow-x-auto">
                    @if($entries->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="p-3 text-left font-bold text-gray-600 text-xs uppercase">📅 Time</th>
                                <th class="p-3 text-left font-bold text-gray-600 text-xs uppercase">👤 Student Name</th>
                                <th class="p-3 text-left font-bold text-gray-600 text-xs uppercase">🆔 ID Number</th>
                                <th class="p-3 text-left font-bold text-gray-600 text-xs uppercase">📝 Reason</th>
                                <th class="p-3 text-center font-bold text-gray-600 text-xs uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($entries as $entry)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 text-gray-600">{{ $entry->created_at->format('h:i A') }}</td>
                                <td class="p-3 font-semibold text-gray-800">{{ $entry->student->name }}</td>
                                <td class="p-3 font-mono text-gray-600">{{ $entry->student->id_number }}</td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">
                                        {{ $entry->reason }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <span class="inline-block px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                        ✓ Logged
                                    </span>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-12">
                        <p class="text-4xl mb-2">🔓</p>
                        <p class="text-gray-600 font-semibold">No entries recorded for today</p>
                        <p class="text-gray-500 text-sm">Gate entry logs will appear here as students are logged in</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
