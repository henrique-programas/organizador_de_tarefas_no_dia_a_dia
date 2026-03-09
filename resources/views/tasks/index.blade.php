<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Minhas Tarefas</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('tasks.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nova Tarefa
        </a>

        @forelse($tasks as $task)
            <div class="bg-white p-4 rounded shadow mb-3 flex justify-between items-center">
                <div>
                    <p class="font-bold {{ $task->completed ? 'line-through text-gray-400' : '' }}">
                        {{ $task->title }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $task->description }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('tasks.edit', $task) }}"
                       class="text-blue-500 hover:underline">Editar</a>

                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Excluir</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Nenhuma tarefa ainda.</p>
        @endforelse
    </div>
</x-app-layout>