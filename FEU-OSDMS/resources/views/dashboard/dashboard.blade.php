<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">OSD Command Center</h2>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-green-600">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Students</p>
                    <p class="text-3xl font-bold text-green-700 mt-2">1,248</p>
                    <p class="text-xs text-gray-500 mt-1">Registered in system</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-yellow-500">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Today's Gate Entries</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">42</p>
                    <p class="text-xs text-gray-500 mt-1">Campus entries logged</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-red-600">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Pending Violations</p>
                    <p class="text-3xl font-bold text-red-700 mt-2">12</p>
                    <p class="text-xs text-gray-500 mt-1">Awaiting review</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-blue-600">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">IntelliMatches</p>
                    <p class="text-3xl font-bold text-blue-700 mt-2">5</p>
                    <p class="text-xs text-gray-500 mt-1">Items found</p>
                </div>
            </div>

            <!-- Main Content Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Quick Access</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('gate.index') }}" class="bg-green-50 border-2 border-green-200 p-4 rounded-lg hover:bg-green-100 transition text-center">
                            <span class="block text-2xl mb-2">🚪</span>
                            <span class="font-semibold text-sm text-green-700">Gate Entry Log</span>
                        </a>
                        <a href="{{ route('violations.report') }}" class="bg-red-50 border-2 border-red-200 p-4 rounded-lg hover:bg-red-100 transition text-center">
                            <span class="block text-2xl mb-2">📊</span>
                            <span class="font-semibold text-sm text-red-700">Violation Reports</span>
                        </a>
                        <a href="{{ route('assets.index') }}" class="bg-blue-50 border-2 border-blue-200 p-4 rounded-lg hover:bg-blue-100 transition text-center">
                            <span class="block text-2xl mb-2">🔍</span>
                            <span class="font-semibold text-sm text-blue-700">IntelliThings</span>
                        </a>
                        <a href="{{ route('students.index') }}" class="bg-purple-50 border-2 border-purple-200 p-4 rounded-lg hover:bg-purple-100 transition text-center">
                            <span class="block text-2xl mb-2">👥</span>
                            <span class="font-semibold text-sm text-purple-700">Student Lists</span>
                        </a>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-gradient-to-br from-green-700 to-green-900 p-6 rounded-lg shadow-sm text-white">
                    <h3 class="font-bold text-lg mb-4">System Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Database</span>
                            <span class="px-2 py-1 bg-green-500 text-green-100 rounded text-xs font-bold">✓ Connected</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm">API Services</span>
                            <span class="px-2 py-1 bg-green-500 text-green-100 rounded text-xs font-bold">✓ Running</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Python Matcher</span>
                            <span class="px-2 py-1 bg-green-500 text-green-100 rounded text-xs font-bold">✓ Ready</span>
                        </div>
                        <hr class="border-green-600 my-3">
                        <p class="text-xs text-green-200">Last updated: {{ now()->format('M d, Y H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Recent Activity</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <div>
                            <p class="font-semibold text-gray-800">Gate Entry: Juan Santos</p>
                            <p class="text-xs text-gray-500">Logged at 2:30 PM</p>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">✓ Success</span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <div>
                            <p class="font-semibold text-gray-800">Violation Report Created: Maria Cruz</p>
                            <p class="text-xs text-gray-500">Created at 1:15 PM</p>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">⏱ Pending</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-800">IntelliMatch Completed: Lost Backpack</p>
                            <p class="text-xs text-gray-500">Matched at 12:45 PM</p>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">🔍 Found</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
