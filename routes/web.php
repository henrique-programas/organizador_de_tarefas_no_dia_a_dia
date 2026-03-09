<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    $tasks = auth()->user()->tasks()->latest()->get();
    $total = $tasks->count();
    $concluidas = $tasks->where('completed', true)->count();
    $pendentes = $tasks->where('completed', false)->count();
    $taxa = $total > 0 ? round(($concluidas / $total) * 100) : 0;
    return view('home', compact('tasks', 'total', 'concluidas', 'pendentes', 'taxa'));
})->middleware(['auth', 'verified'])->name('home');

Route::get('/teste', function () {
    return 'funcionando!';
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
