<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Gate Entry Log (No ID)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white p-8 rounded-xl shadow-sm border-t-4 border-yellow-500">
                <h3 class="font-bold text-gray-400 text-[10px] uppercase tracking-widest mb-4">Log Temporary Entry</h3>
                <form action="{{ route('gate.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Student ID Number</label>
                            <input type="text" name="id_number" placeholder="e.g., 202312345" required
                                   class="w-full border-gray-300 rounded-lg focus:border-yellow-500 focus:ring-yellow-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Entry Reason</label>
                            <select name="reason" class="w-full border-gray-300 rounded-lg focus:border-yellow-500 focus:ring-yellow-500">
                                <option value="Forgot ID">Forgot ID</option>
                                <option value="Lost ID">Lost ID</option>
                                <option value="Damaged ID">Damaged ID</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-yellow-600 text-white font-black py-2 rounded-lg hover:bg-yellow-700 transition uppercase text-xs">
                                Record Entry
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-bold text-gray-800 text-sm mb-4">Today's Entry Logs</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-400 border-b border-gray-100">
                            <tr>
                                <th class="pb-3 font-bold uppercase text-[10px]">Time</th>
                                <th class="pb-3 font-bold uppercase text-[10px]">Student Name</th>
                                <th class="pb-3 font-bold uppercase text-[10px]">Reason</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            {{-- This would be looped from $entries --}}
                            @forelse($entries as $entry)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 text-gray-500">{{ $entry->entry_time->format('h:i A') }}</td>
                                <td class="py-4 font-bold text-gray-900">{{ $entry->student->name }}</td>
                                <td class="py-4">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-md text-[10px] font-bold">
                                        {{ $entry->reason }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-10 text-center text-gray-400 italic">No entries recorded for today.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>