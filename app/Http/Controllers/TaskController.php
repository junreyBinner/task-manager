<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $totalTasks     = Task::where('user_id', $userId)->count();
        $pendingTasks   = Task::where('user_id', $userId)->where('is_done', false)->count();
        $completedTasks = Task::where('user_id', $userId)->where('is_done', true)->count();
        return view('dashboard', compact('totalTasks', 'pendingTasks', 'completedTasks'));
    }

    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('is_done', false)
            ->latest()
            ->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    // ── Show the calendar page
    public function calendar()
    {
        return view('tasks.calendar');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'scheduled_at' => 'nullable|date',
        ]);

        Task::create([
            'user_id'      => Auth::id(),
            'title'        => $request->title,
            'description'  => $request->description,
            'scheduled_at' => $request->scheduled_at,
            'is_done'      => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title'        => 'required|string|max:255',
            'scheduled_at' => 'nullable|date',
        ]);

        $task->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function done(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            if (request()->expectsJson()) return response()->json(['error' => 'Forbidden'], 403);
            abort(403);
        }
        $task->update(['is_done' => true]);
        if (request()->expectsJson()) return response()->json(['success' => true]);
        return back()->with('success', 'Task marked as completed!');
    }

    public function completed()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('is_done', true)
            ->latest()
            ->get();
        return view('tasks.completed', compact('tasks'));
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        $task->delete();
        if (request()->expectsJson()) return response()->json(['deleted' => true]);
        return back()->with('success', 'Task deleted successfully!');
    }

    // ── CALENDAR JSON API ──────────────────────────────────────────

    public function calendarTasks()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->whereNotNull('scheduled_at')
            ->latest()
            ->get(['id', 'title', 'description', 'scheduled_at', 'is_done']);

        return response()->json($tasks);
    }

    public function storeFromCalendar(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'scheduled_at' => 'required|date',
        ]);

        $task = Task::create([
            'user_id'      => Auth::id(),
            'title'        => $request->title,
            'description'  => $request->description ?? '',
            'scheduled_at' => $request->scheduled_at,
            'is_done'      => false,
        ]);

        return response()->json($task->fresh(), 201);
    }

    public function destroyFromCalendar(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $task->delete();
        return response()->json(['deleted' => true]);
    }
}
