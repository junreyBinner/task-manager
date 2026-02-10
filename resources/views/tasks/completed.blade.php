<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Completed Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Completed Tasks</h1>
                <a href="{{ route('tasks.index') }}"
                    class="px-4 py-2 bg-gray-600 text-black rounded hover:bg-gray-700 transition">
                    Back to My Tasks
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-lg border overflow-hidden">

                @if($tasks->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Completed Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $task->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $task->updated_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('tasks.destroy', $task->id) }}"
                                    method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="if(confirm('Delete this completed task?')) { this.form.submit(); }"
                                        class="text-red-600 hover:text-red-800 hover:underline">
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
                    <p class="text-gray-500 mb-4">No completed tasks yet.</p>
                    <a href="{{ route('tasks.index') }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700 transition">
                        View Pending Tasks
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>