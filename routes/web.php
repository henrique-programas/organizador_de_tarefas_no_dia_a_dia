<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {

    $tasks = auth()->user()->tasks()->latest()->get();
    $total = $tasks->count();
    $concluidas = $tasks->where('completed', true)->count();
    $pendentes  = $tasks->where('completed', false)->count();
    $taxa = $total > 0 ? round(($concluidas / $total) * 100) : 0;

    $tarefaDiaria  = auth()->user()->tasks()->where('type', 'diaria')->where('completed', false)->latest()->first()
                  ?? auth()->user()->tasks()->where('type', 'diaria')->latest()->first();

    $tarefaSemanal = auth()->user()->tasks()->where('type', 'semanal')->where('completed', false)->latest()->first()
                  ?? auth()->user()->tasks()->where('type', 'semanal')->latest()->first();

    $tarefaMensal  = auth()->user()->tasks()->where('type', 'mensal')->where('completed', false)->latest()->first()
                  ?? auth()->user()->tasks()->where('type', 'mensal')->latest()->first();
    
    // Separando as tarefas por tipo em sub-collections
    $diarias  = $tasks->where('type', 'diaria');
    $semanais = $tasks->where('type', 'semanal');
    $mensais  = $tasks->where('type', 'mensal');
    
    $totalDiarias = $diarias->count();
    $totalSemanal = $semanais->count();
    $totalMensal  = $mensais->count();
    
    // Pendentes por tipo (novo — pode usar no blade se quiser)
    $pendentesDiarias  = $diarias->where('completed', false)->count();
    $pendentesSemanaias = $semanais->where('completed', false)->count();
    $pendentesMensais  = $mensais->where('completed', false)->count();
    
    // Taxas de conclusão por tipo
    $taxaDiaria  = $totalDiarias > 0
        ? round($diarias->where('completed', true)->count()  / $totalDiarias  * 100) : 0;
    $taxaSemanal = $totalSemanal > 0
        ? round($semanais->where('completed', true)->count() / $totalSemanal * 100) : 0;
    $taxaMensal  = $totalMensal  > 0
        ? round($mensais->where('completed', true)->count()  / $totalMensal  * 100) : 0;

    $tarefasEsteMes = $tasks->filter(function($task) {
        return $task->created_at->month === now()->month &&
               $task->created_at->year === now()->year;
    })->count();

    $concluidasNoPrazo = $tasks->filter(function($task) {
        return $task->completed &&
               $task->due_date &&
               $task->updated_at->toDateString() <=$task->due_date;
    })->count();

    $streak = 0;
    $dia = now()->startOfDay();
    while (true) {
        $temAtividade = $tasks->filter(function($task) use ($dia) {
            return $task->created_at->toDateString() === $dia->toDateString() ||
            ($task->completed && $task->updated_at->toDateString() === $dia->toDateString());
        })->count() > 0;

        if (!$temAtividade) break;
        $streak++;
        $dia->subDay();
    }
    
    return view('home', compact(
        'tasks', 'total', 'concluidas', 'pendentes', 'taxa',
        'tarefaDiaria', 'tarefaSemanal', 'tarefaMensal',
        'totalDiarias', 'totalSemanal', 'totalMensal',
        'taxaDiaria', 'taxaSemanal', 'taxaMensal',
        'pendentesDiarias', 'pendentesSemanaias', 'pendentesMensais',
        'tarefasEsteMes', 'concluidasNoPrazo', 'streak' // ← faltava isso
    ));
})->middleware(['auth', 'verified'])->name('home');

Route::get('/teste', function () {
    return 'funcionando!';
});

Route::get('/tasks/calendar-events', function(){
    $tasks = auth()->user()->tasks()->whereNotNull('due_date')->get();

    $events = $tasks->map(function ($task) {
        return[
            'id' => $task->id,
            'title' => $task->title,
            'start' => $task->due_date,
            'color' => $task->completed ? '#10B981' : '#3B82F6',
        ];
    });

    return response()->json($events);
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/tasks/complete-all', [TaskController::class, 'completeAll'])->name('tasks.completeAll');
    Route::delete('/tasks/destroy-all', [TaskController::class, 'destroyAll'])->name('tasks.destroyAll');
    Route::resource('tasks', TaskController::class);
});


require __DIR__.'/auth.php';
