<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">⚠️ Record New Disciplinary Offense</h2>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-sm border-l-4 border-red-600">
                <div class="flex items-center mb-6">
                    <span class="text-3xl mr-3">📋</span>
                    <h3 class="font-bold text-lg text-gray-800">Violation Entry Form</h3>
                </div>

                <form action="{{ route('violations.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Student Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-2">👤 Target Student</label>
                        <select name="student_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none">
                            <option value="">— Select a student —</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->id_number }} - {{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Offense Type & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase mb-2">⚠️ Offense Category</label>
                            <select name="offense_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none">
                                <option value="">— Select category —</option>
                                <option value="Uniform Violation">Uniform Violation</option>
                                <option value="ID Misuse">ID Misuse</option>
                                <option value="Unauthorized Access">Unauthorized Access</option>
                                <option value="Late Entry">Late Entry</option>
                                <option value="Major Offense">Major Offense</option>
                                <option value="Conduct">Conduct Violation</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('offense_type')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase mb-2">📊 Status</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none">
                                <option value="Pending">Pending Investigation</option>
                                <option value="Resolved">Resolved Immediately</option>
                                <option value="Escalated">Escalated for Review</option>
                            </select>
                        </div>
                    </div>

                    <!-- Reporter & Academic Term -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase mb-2">📝 Findings</label>
                            <input type="text" name="findings" placeholder="Brief findings..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase mb-2">📅 Academic Term</label>
                            <input type="text" name="academic_term" placeholder="e.g., 1st Sem 2026"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none">
                        </div>
                    </div>

                    <!-- Incident Description -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-2">🔍 Incident Details</label>
                        <textarea name="description" rows="4" placeholder="Provide a detailed description of the incident..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Include time, location, witnesses, and specific details.</p>
                    </div>

                    <!-- Recommendation -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase mb-2">💬 Recommendation</label>
                        <textarea name="recommendation" rows="3" placeholder="Recommended action or next steps..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-gray-100">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-lg transition uppercase text-sm">
                            📋 Log to Official Record
                        </button>
                        <a href="{{ route('violations.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 rounded-lg transition uppercase text-sm text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
