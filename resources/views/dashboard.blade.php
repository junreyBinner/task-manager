<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Welcome, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-gray-500">
                    Here’s an overview of your tasks today.
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- Total Tasks -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="text-sm text-gray-500">Total Tasks</h3>
                    <p class="text-3xl font-bold text-gray-800">
                        {{ $totalTasks ?? 0 }}
                    </p>
                </div>

                <!-- Pending Tasks -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="text-sm text-gray-500">Pending Tasks</h3>
                    <p class="text-3xl font-bold text-yellow-500">
                        {{ $pendingTasks ?? 0 }}
                    </p>
                </div>

                <!-- Completed Tasks -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="text-sm text-gray-500">Completed Tasks</h3>
                    <p class="text-3xl font-bold text-green-600">
                        {{ $completedTasks ?? 0 }}
                    </p>
                </div>

            </div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Quick Actions
                </h3>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('tasks.index') }}"
                       class="px-4 py-2 bg-indigo-600 text-black rounded hover:bg-indigo-700 transition">
                        My Tasks
                    </a>

                    <a href="{{ route('tasks.create') }}"
                       class="px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700 transition">
                        Create Task
                    </a>

                    <a href="{{ route('tasks.completed') }}"
                       class="px-4 py-2 bg-gray-700 text-black rounded hover:bg-gray-800 transition">
                        Completed Tasks
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
