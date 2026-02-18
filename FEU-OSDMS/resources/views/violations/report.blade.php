<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">Disciplinary Analytics</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-gray-400 text-xs uppercase mb-6 tracking-widest">Student Risk Ranking</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    @foreach($offenders as $student)
                    <div class="flex items-center justify-between p-4 border rounded-xl hover:bg-gray-50 transition">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold mr-4">
                                {{ $student->violations_count }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500 italic">{{ $student->id_number }} • {{ $student->program_code }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                {{ $student->violations_count >= 3 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $student->violations_count >= 3 ? 'Critical' : 'Warning' }}
                            </span>
                            <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 font-bold text-sm hover:underline">
                                Full History →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>