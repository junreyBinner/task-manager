<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Task CRUD — /tasks/completed and /tasks/calendar BEFORE /tasks/{task}
    Route::get('/tasks',                 [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create',          [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks',                [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/completed',       [TaskController::class, 'completed'])->name('tasks.completed');
    Route::get('/tasks/calendar',        [TaskController::class, 'calendar'])->name('tasks.calendar');
    Route::get('/tasks/{task}/edit',     [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}',          [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}',       [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/done',   [TaskController::class, 'done'])->name('tasks.done');

    // Calendar JSON API
    Route::get('/calendar-api/tasks',                [TaskController::class, 'calendarTasks']);
    Route::post('/calendar-api/tasks',               [TaskController::class, 'storeFromCalendar']);
    Route::delete('/calendar-api/tasks/{task}',      [TaskController::class, 'destroyFromCalendar']);
});

require __DIR__ . '/auth.php';
