<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">My Tasks</h1>
                <a href="{{ route('tasks.create') }}"
                    class="px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700 transition">
                    + Create Task
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg border overflow-hidden">

                @if($tasks->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $task->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $task->description ?? '-' }}</td>

                            <td class="px-6 py-4">
                                @if($task->is_done)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Completed</span>
                                @else
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">Pending</span>
                                <!-- Mark as done button -->
                                <form action="{{ route('tasks.done', $task->id) }}" method="POST" class="inline ml-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="text-sm text-blue-600 hover:text-blue-800">
                                        Mark as done
                                    </button>
                                </form>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $task->created_at->format('M d, Y') }}
                            </td>

                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('tasks.destroy', $task->id) }}"
                                    method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="if(confirm('Delete this task?')) { this.form.submit(); }"
                                        class="text-red-600 hover:text-red-800 hover:underline ml-2">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-8 text-center">
                    <p class="text-gray-500 mb-4">No tasks found. Create your first task!</p>
                    <a href="{{ route('tasks.create') }}"
                        class="inline-block px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700 transition">
                        Create Your First Task
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>