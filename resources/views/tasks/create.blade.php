<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nova Tarefa</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Título</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border rounded px-3 py-2">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Descrição</label>
                <textarea name="description" rows="3"
                          class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                Salvar
            </button>
            <a href="{{ route('tasks.index') }}" class="ml-3 text-gray-500">Cancelar</a>
        </form>
    </div>
</x-app-layout>