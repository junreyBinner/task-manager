<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Dashboard method
    public function dashboard()
    {
        $userId = Auth::id();

        $totalTasks = Task::where('user_id', $userId)->count();
        $pendingTasks = Task::where('user_id', $userId)
            ->where('is_done', false)
            ->count();
        $completedTasks = Task::where('user_id', $userId)
            ->where('is_done', true)
            ->count();

        return view('dashboard', compact('totalTasks', 'pendingTasks', 'completedTasks'));
    }

    // Main tasks index
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('is_done', false)
            ->latest()
            ->get();
        return view('tasks.index', compact('tasks'));
    }

    // Store new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'is_done' => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    // Show edit form
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    // Mark task as done
    public function done(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->update(['is_done' => true]);
        return back()->with('success', 'Task marked as completed!');
    }

    // Show completed tasks
    public function completed()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('is_done', true)
            ->latest()
            ->get();
        return view('tasks.completed', compact('tasks'));
    }

    // Delete task
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();
        return back()->with('success', 'Task deleted successfully!');
    }
}
