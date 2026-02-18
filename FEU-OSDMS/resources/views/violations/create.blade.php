<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Record New Disciplinary Offense') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border-t-4 border-red-600">
                <h3 class="font-bold text-gray-400 text-[10px] uppercase tracking-widest mb-6">Violation Entry Form</h3>
                
                <form action="{{ route('violations.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Target Student</label>
                            <select name="student_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Select a student to log...</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->id_number }} - {{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Offense Category</label>
                                <select name="offense_type" required class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="Uniform Violation">Uniform Violation</option>
                                    <option value="ID Misuse">ID Misuse</option>
                                    <option value="Unauthorized Access">Unauthorized Access</option>
                                    <option value="Late Entry">Late Entry</option>
                                    <option value="Major Offense">Major Offense</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Action Status</label>
                                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="Pending">Pending Investigation</option>
                                    <option value="Resolved">Resolved Immediately</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Incident Details (Optional)</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg" placeholder="Briefly describe the incident..."></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-red-600 text-white font-black py-3 rounded-lg hover:bg-red-700 transition uppercase tracking-widest text-xs">
                                Log to Official Record
                            </button>
                            <a href="{{ route('dashboard') }}" class="block text-center mt-4 text-xs text-gray-400 font-bold hover:text-gray-600 uppercase">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>