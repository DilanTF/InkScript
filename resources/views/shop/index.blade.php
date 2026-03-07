<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tienda InkScript: Libros y Obras de Autores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        <!-- Imagen de portada (Placeholder si no hay) -->
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="object-cover h-full w-full">
                            @else
                                <span class="text-gray-400">Sin Portada</span>
                            @endif
                        </div>

                        <div class="p-4 flex-grow">
                            <span class="text-xs font-bold text-indigo-500 uppercase">{{ $book->genre }}</span>
                            <h3 class="text-lg font-bold text-gray-900 mt-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $book->description }}</p>
                        </div>

                        <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                            <span class="text-xl font-bold text-green-600">{{ $book->price }}€</span>
                            <a href="{{ route('shop.show', $book) }}" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm hover:bg-indigo-700">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>