<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $story->title }}
            </h2>
            <a href="{{ route('stories.index') }}" class="text-sm text-gray-600 hover:underline">Volver</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información de la Historia -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-2">Sinopsis</h3>
                <p class="text-gray-700 italic">{{ $story->description }}</p>
                
                @if(auth()->id() === $story->user_id)
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800 font-bold mb-2">Zona de Autor:</p>
                        <a href="{{ route('stories.chapters.create', $story) }}" class="bg-blue-600 text-white px-4 py-2 rounded text-xs hover:bg-blue-700">
                            + Escribir Capítulo
                        </a>
                    </div>
                @endif
            </div>

            <!-- Listado de Capítulos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Capítulos</h3>
                @forelse($story->chapters as $chapter)
                    <div class="py-2 border-b flex justify-between items-center">
                        <span class="text-gray-800">{{ $chapter->order_number }}. {{ $chapter->title }}</span>
                        <!-- Botón para entrar al capítulo -->
                        <a href="{{ route('stories.chapters.show', [$story, $chapter]) }}" class="bg-indigo-50 text-indigo-700 px-4 py-1 rounded-full text-sm font-bold hover:bg-indigo-100 transition">Leer Capítulo</a>
                    </div>
                @empty
                    <p class="text-gray-500">No hay capítulos aún.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>