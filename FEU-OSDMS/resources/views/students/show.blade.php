<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">Student Profile: {{ $student->id_number }}</h2>
            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold uppercase">{{ $student->program_code }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if($student->lostItems->where('is_claimed', false)->count() > 0)
            <div class="bg-blue-600 text-white p-4 rounded-lg shadow-lg flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-2xl mr-4">🤖</span>
                    <div>
                        <p class="font-bold">IntelliMatch Notification</p>
                        <p class="text-sm opacity-90">This student has an active lost item report with a potential AI match.</p>
                    </div>
                </div>
                <a href="{{ route('assets.index') }}" class="bg-white text-blue-600 px-4 py-2 rounded font-bold text-xs uppercase">View Match</a>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-green-700">
                    <h3 class="font-bold text-gray-400 text-xs uppercase mb-4">Account Details</h3>
                    <p class="text-lg font-bold">{{ $student->name }}</p>
                    <p class="text-sm text-gray-600">{{ $student->email }}</p>
                    <p class="text-sm text-gray-600 mt-2">Campus: <span class="font-semibold">{{ $student->campus }}</span></p>
                </div>

                <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="font-bold text-gray-400 text-xs uppercase mb-4">Disciplinary Records</h3>
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-gray-400 border-b">
                                <th class="pb-2">Date</th>
                                <th class="pb-2">Offense</th>
                                <th class="pb-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($student->violations as $violation)
                            <tr class="border-b last:border-0">
                                <td class="py-3 text-gray-500">{{ $violation->created_at->format('M d, Y') }}</td>
                                <td class="py-3 font-semibold">{{ $violation->offense_type }}</td>
                                <td class="py-3"><span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-[10px] font-bold">{{ $violation->status }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="py-4 text-center text-gray-400">No violations found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>