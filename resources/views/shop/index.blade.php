<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tienda InkScript: Libros y Obras de Autores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col border border-gray-100 hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="object-cover h-full w-full">
                            @else
                                <span class="text-gray-400 italic">Sin Portada</span>
                            @endif
                        </div>

                        <div class="p-4 flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-bold text-indigo-500 uppercase">{{ $book->genre }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase {{ $book->is_digital ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ $book->is_digital ? 'Digital' : 'Físico' }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 mt-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $book->description }}</p>
                            
                            <div class="mt-3">
                                @if(!$book->is_digital)
                                    <p class="text-xs {{ $book->stock > 0 ? 'text-gray-500' : 'text-red-500 font-bold' }}">
                                        {{ $book->stock > 0 ? 'Stock: ' . $book->stock . ' udes.' : 'Agotado' }}
                                    </p>
                                @else
                                    <p class="text-xs text-blue-500 italic">Disponible al instante</p>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 border-t bg-gray-50 flex flex-col space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-green-600">{{ number_format($book->price, 2) }}€</span>
                                <a href="{{ route('shop.show', $book) }}" class="text-indigo-600 text-xs font-semibold hover:underline">
                                    Ver Detalles
                                </a>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" 
                                    class="w-full text-center bg-indigo-600 text-white px-3 py-2 rounded-md text-sm font-bold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ (!$book->is_digital && $book->stock <= 0) ? 'disabled' : '' }}>
                                    @if(!$book->is_digital && $book->stock <= 0)
                                        Sin Stock
                                    @else
                                        🛒 Añadir al Carrito
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-lg shadow">
                        <p class="text-gray-500">Aún no hay libros publicados en la tienda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>