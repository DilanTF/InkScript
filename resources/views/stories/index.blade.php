<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Historias en InkScript') }}
            </h2>
            <a href="{{ route('stories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Nueva Historia
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($stories->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 italic">Aún no has creado ninguna historia. ¡Empieza ahora!</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($stories as $story)
                                <div class="border rounded-lg p-4 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <!-- Enlace a la vista de detalle (show) de la historia -->
                                        <a href="{{ route('stories.show', $story) }}" class="text-xl font-bold text-indigo-600 hover:underline">
                                            {{ $story->title }}
                                        </a>
                                        <p class="mt-2 text-gray-600 line-clamp-3">{{ $story->description }}</p>
                                    </div>
                                    
                                    <div class="mt-4 flex space-x-2 border-t pt-4">
                                        <a href="{{ route('stories.edit', $story) }}" class="text-sm text-blue-600 hover:text-blue-900">Editar</a>
                                        
                                        <form action="{{ route('stories.destroy', $story) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer borrar esta historia?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">Borrar</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>