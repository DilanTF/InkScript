<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Encabezado -->
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                    Librería Oficial InkScript
                </h2>
                <p class="text-gray-500 text-lg">Descubre ediciones físicas de la editorial y E-books exclusivos de nuestros Autores Independientes.</p>
            </div>

            @if(session('error'))
                <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 shadow-sm rounded-2xl flex items-center max-w-3xl mx-auto">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- PANEL LATERAL: FILTROS -->
                <div class="lg:w-1/4">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-28">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-black text-lg text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">Filtros</h3>
                            @if(!empty($selectedGenres) || $searchTerm || request('author_type'))
                                <a href="{{ route('shop.index') }}" class="text-xs font-bold text-red-500 hover:text-red-700">Limpiar</a>
                            @endif
                        </div>
                        
                        <form action="{{ route('shop.index') }}" method="GET" id="filter-form">
                            <!-- Buscador integrado en los filtros -->
                            <div class="mb-6 relative">
                                <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Buscar por título..." 
                                       class="w-full border-gray-200 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] pl-10 py-2.5 text-sm bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>

                            <!-- Filtro Editorial vs Independientes -->
                            <div class="mb-6 pb-6 border-b border-gray-100">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Origen de Publicación</h4>
                                <div class="space-y-3">
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="author_type" value="" onchange="document.getElementById('filter-form').submit()"
                                               class="w-4 h-4 text-[#744E36] focus:ring-[#744E36]" {{ empty($authorType) ? 'checked' : '' }}>
                                        <span class="text-gray-700 font-medium group-hover:text-[#744E36] text-sm">Todos</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="author_type" value="editorial" onchange="document.getElementById('filter-form').submit()"
                                               class="w-4 h-4 text-[#744E36] focus:ring-[#744E36]" {{ $authorType === 'editorial' ? 'checked' : '' }}>
                                        <span class="text-gray-700 font-medium group-hover:text-[#744E36] text-sm">Sello InkScript</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="author_type" value="indie" onchange="document.getElementById('filter-form').submit()"
                                               class="w-4 h-4 text-[#744E36] focus:ring-[#744E36]" {{ $authorType === 'indie' ? 'checked' : '' }}>
                                        <span class="text-gray-700 font-medium group-hover:text-[#744E36] text-sm">Autores Independientes</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Checkboxes de Géneros -->
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Géneros Literarios</h4>
                                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                    @foreach($allGenres as $genre)
                                        <label class="flex items-center space-x-3 cursor-pointer group">
                                            <input type="checkbox" name="genres[]" value="{{ $genre }}" 
                                                   {{ in_array($genre, $selectedGenres) ? 'checked' : '' }}
                                                   onchange="document.getElementById('filter-form').submit()"
                                                   class="w-5 h-5 rounded border-gray-300 text-[#744E36] focus:ring-[#744E36] transition-colors cursor-pointer">
                                            <span class="text-gray-700 font-medium group-hover:text-[#744E36] transition-colors text-sm">{{ $genre }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- CUADRÍCULA DE RESULTADOS DE LA TIENDA -->
                <div class="lg:w-3/4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($books as $book)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all flex flex-col group transform hover:-translate-y-1">
                                <!-- Portada -->
                                <div class="h-64 bg-gray-100 relative overflow-hidden flex items-center justify-center">
    
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if($book->is_digital)
                                        <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-[9px] font-black uppercase tracking-wider rounded shadow-sm text-indigo-700">Digital</span>
                                    @else
                                        <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-[9px] font-black uppercase tracking-wider rounded shadow-sm text-[#744E36]">Físico</span>
                                    @endif
                                </div>
                                
                                <div class="absolute bottom-3 right-3 flex flex-col gap-2">
                                    @if($book->user_id)
                                        <span class="px-2 py-1 bg-amber-500/90 backdrop-blur-sm text-[9px] font-black uppercase tracking-wider rounded shadow-sm text-white flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Indie
                                        </span>
                                    @endif
                                </div>
                            </div>
                                                            
                                <!-- Info -->
                                <div class="p-5 flex flex-col flex-grow justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-widest mb-1 text-gray-400">{{ $book->genre ?: 'Ficción General' }}</p>
                                        <h3 class="font-bold text-lg text-gray-900 leading-tight mb-1 group-hover:text-[#744E36] transition-colors line-clamp-2" style="font-family: 'Instrument Sans', sans-serif;">{{ $book->title }}</h3>
                                        <!-- Vendedor -->
                                        <p class="text-xs text-gray-500 mb-2">
                                            Por <span class="font-bold text-gray-700">{{ $book->user ? $book->user->name : 'Sello InkScript' }}</span>
                                        </p>
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-gray-50 flex justify-between items-center">
                                        <div class="flex flex-col">
                                            <span class="text-2xl font-black text-gray-900">{{ number_format($book->price, 2) }} €</span>
                                            @if(!$book->is_digital && $book->stock <= 0)
                                                <span class="text-[9px] font-bold text-red-500 uppercase tracking-widest mt-0.5">Agotado</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('shop.show', $book->id) }}" class="px-5 py-2.5 bg-[#744E36] text-white text-xs font-bold rounded-full hover:bg-[#5c3d2a] transition-colors shadow-sm">
                                            Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white p-16 text-center rounded-3xl border border-dashed border-gray-200">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No hay resultados</h3>
                                <p class="text-gray-500">Prueba a desmarcar algunos géneros o cambiar el tipo de publicación.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>