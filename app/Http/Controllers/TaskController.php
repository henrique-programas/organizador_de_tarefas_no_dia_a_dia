<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Events\CrudActionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = auth()->user()->tasks()->create(
            $request->only('title', 'description', 'type', 'priority', 'due_date')
        );

        broadcast(new CrudActionEvent('created', 'Tarefa', $task->id, Auth::id()));

        return redirect()->route('home')->with('success', 'Tarefa criada!');
    }

    public function edit(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'completed'   => $request->has('completed'),
            'type'        => $request->type,
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
        ]);

        broadcast(new CrudActionEvent('updated', 'Tarefa', $task->id, Auth::id()));

        return redirect()->route('home')->with('success', 'Tarefa atualizada!');
    }

    public function destroy(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $id = $task->id;
        $task->delete();

        broadcast(new CrudActionEvent('deleted', 'Tarefa', $id, Auth::id()));

        return redirect()->route('home')->with('success', 'Tarefa removida!');
    }

    public function completeAll()
    {
        auth()->user()->tasks()->where('completed', false)->update(['completed' => true]);
        return redirect()->route('home')->with('success', 'Todas as tarefas concluídas!');
    }

    public function destroyAll()
    {
        auth()->user()->tasks()->delete();
        return redirect()->route('home')->with('success', 'Todas as tarefas excluídas!');
    }
}