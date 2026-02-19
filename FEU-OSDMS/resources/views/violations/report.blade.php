<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">📊 Violation Analytics & Reports</h2>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto">

            <!-- Risk Ranking Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">⚠️ Student Risk Ranking</h3>
                        <p class="text-sm text-gray-600">Students ranked by violation count</p>
                    </div>
                    <span class="text-3xl">📋</span>
                </div>

                <div class="space-y-2">
                    @forelse($offenders as $student)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center flex-1">
                            <!-- Violation Count Badge -->
                            <div class="h-12 w-12 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold mr-4 text-lg">
                                {{ $student->violations_count }}
                            </div>

                            <!-- Student Info -->
                            <div>
                                <p class="font-bold text-gray-900">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500">
                                    🆔 {{ $student->id_number }} • 📚 {{ $student->program_code ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Status & Action -->
                        <div class="flex items-center space-x-3">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase
                                {{ $student->violations_count >= 3 ? 'bg-red-100 text-red-700' : ($student->violations_count >= 1 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ $student->violations_count >= 3 ? '🔴 Critical' : ($student->violations_count >= 1 ? '🟡 Warning' : '🟢 Clear') }}
                            </span>
                            <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">
                                View Profile →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <p class="text-4xl mb-2">✨</p>
                        <p class="text-gray-600 font-semibold">No violations recorded</p>
                        <p class="text-gray-500 text-sm">All students have clean records</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
