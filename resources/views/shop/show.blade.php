<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $book->title }}
            </h2>
            <a href="{{ route('shop.index') }}" class="text-sm text-indigo-600 hover:underline">
                &larr; Volver a la tienda
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="md:flex md:space-x-12">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <div class="aspect-w-2 aspect-h-3 bg-gray-200 rounded-xl overflow-hidden shadow-lg border border-gray-100">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="object-cover w-full h-full transform hover:scale-105 transition duration-500">
                            @else
                                <div class="flex flex-col items-center justify-center h-80 bg-gradient-to-br from-gray-100 to-gray-200 text-gray-400">
                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="font-bold uppercase text-xs tracking-widest">{{ $book->title }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="md:w-2/2">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-bold rounded-full uppercase tracking-wider">
                                {{ $book->genre }}
                            </span>
                            @if($book->is_digital || $book->stock > 0)
                                <span class="flex items-center text-green-600 text-sm font-medium">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> {{ $book->is_digital ? 'Disponible Digital' : 'En Stock (' . $book->stock . ')' }}
                                </span>
                            @else
                                <span class="flex items-center text-red-600 text-sm font-medium">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Agotado
                                </span>
                            @endif
                        </div>
                        
                        <h1 class="text-4xl font-extrabold text-gray-900 mt-4 leading-tight">{{ $book->title }}</h1>
                        
                        <div class="mt-8 bg-gray-50 rounded-xl p-6 border border-gray-100">
                            <div class="flex items-baseline space-x-2">
                                <span class="text-5xl font-black text-indigo-700">{{ number_format($book->price, 2) }}€</span>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                
                                <div class="flex flex-wrap items-center gap-4">
                                    @if(!$book->is_digital && $book->stock > 0)
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $book->stock }}" class="w-20 rounded-lg border-gray-300 text-center">
                                    @else
                                        <input type="hidden" name="quantity" value="1">
                                    @endif

                                    <button type="submit" @if(!$book->is_digital && $book->stock <= 0) disabled @endif 
                                        class="flex-grow md:flex-none bg-indigo-600 hover:bg-indigo-800 disabled:bg-gray-400 text-white font-bold py-4 px-12 rounded-xl shadow-lg transition-all transform active:scale-95 flex items-center justify-center">
                                        🛒 {{ $book->stock > 0 || $book->is_digital ? 'Añadir al carrito' : 'No disponible' }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Sinopsis</h3>
                            <p class="text-gray-700 leading-relaxed italic bg-indigo-50/30 p-4 rounded-lg">
                                "{{ $book->description }}"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-16 pt-8 border-t">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8">Opiniones de los lectores</h3>
                    
                    @php 
                        // Obtenemos los comentarios de todos los capítulos de la historia asociada
                        $comments = $book->story ? $book->story->chapters->flatMap->comments->sortByDesc('created_at')->take(5) : collect();
                    @endphp

                    <div class="space-y-6">
                        @forelse($comments as $comment)
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-bold text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 italic">"{{ $comment->content }}"</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">Aún no hay reseñas para esta obra.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>