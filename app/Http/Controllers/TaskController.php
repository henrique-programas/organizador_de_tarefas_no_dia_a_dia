<?php

namespace App\Http\Controllers;

use App\Models\Task;
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

        auth()->user()->tasks()->create($request->only('title', 'description'));

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada!');
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
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada!');
    }

    public function destroy(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa removida!');
    }
}