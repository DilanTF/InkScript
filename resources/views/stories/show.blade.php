<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $story->title }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('stories.index') }}" class="text-sm text-gray-600 hover:underline">Volver al listado</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información de la Historia -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-2">Sinopsis</h3>
                <p class="text-gray-700 italic">{{ $story->description }}</p>
            </div>

            <!-- Listado de Capítulos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Capítulos de la Obra</h3>
                    <!-- Botón para ir al formulario de creación de capítulos que hicimos antes -->
                    <a href="{{ route('stories.chapters.create', $story) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                        + Añadir Capítulo
                    </a>
                </div>

                @if($story->chapters->isEmpty())
                    <p class="text-gray-500 text-center py-4">Aún no has escrito capítulos para esta historia.</p>
                @else
                    <div class="space-y-4">
                        @foreach($story->chapters as $chapter)
                            <div class="flex justify-between items-center border-b pb-4">
                                <div>
                                    <span class="text-sm font-bold text-indigo-600">Capítulo {{ $chapter->order_number }}</span>
                                    <h4 class="text-md font-semibold">{{ $chapter->title }}</h4>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="#" class="text-blue-500 hover:underline text-sm">Leer</a>
                                    <a href="#" class="text-gray-500 hover:underline text-sm">Editar</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>