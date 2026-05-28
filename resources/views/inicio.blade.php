<x-app-layout>
    <!-- Quitamos el header gris por defecto para un diseño más limpio -->
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            <!-- MENSAJE DE BIENVENIDA Y BOTÓN AL PANEL -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Bienvenido, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-500 mt-1 text-lg">¿Qué mundo vas a descubrir hoy?</p>
                </div>
                
                <!-- NUEVO BOTÓN: Acceso directo al Panel -->
                <div>
                    <a href="{{ route('panel') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#744E36] text-white font-bold rounded-full hover:bg-[#5c3d2a] transition shadow-md group">
                        <span>Ir a Mi Panel</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
            </div>
            
            <!-- 1. OBRAS DEL MES (Destacado) -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-800" style="color: #744E36;">Obras del Mes</h2>
                    <a href="{{ route('shop.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition">Ver todo &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($featuredBooks as $book)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 group flex flex-col">
                            <!-- Imagen del libro -->
                            <div class="h-48 bg-gray-100 relative overflow-hidden rounded-t-3xl flex items-center justify-center">
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @if($book->genre)
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-black uppercase tracking-wider rounded-full shadow-sm text-[#744E36]">
                                            {{ explode(', ', $book->genre)[0] }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <!-- Datos del libro -->
                            <div class="p-6 flex flex-col flex-grow justify-between">
                                <div>
                                    <h3 class="font-bold text-xl text-gray-900 leading-tight group-hover:text-[#744E36] transition-colors">{{ $book->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $book->description }}</p>
                                </div>
                                <div class="mt-6 flex items-center justify-between">
                                    <span class="text-2xl font-black text-gray-900">{{ number_format($book->price, 2) }} €</span>
                                    <a href="{{ route('shop.show', $book->id) }}" class="px-5 py-2 text-white text-sm font-bold rounded-full transition-colors" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                                        Comprar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Diseño que se muestra cuando no hay libros en la BD -->
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-white p-8 rounded-2xl border border-dashed border-gray-300 text-center shadow-sm">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-200">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Aún no hay obras destacadas este mes</h3>
                            <p class="text-gray-500 mb-4 max-w-md mx-auto">La tienda está preparándose para recibir nuevas y emocionantes obras. ¡Vuelve pronto!</p>
                            <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2 text-white font-bold rounded-full transition-colors" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                                Explorar la tienda
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- 2. Seccion dividida: Recomendaciones vs Historias Gratuitas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Columna Izquierda: Recomendaciones para ti -->
                <section>
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="text-yellow-500">✨</span> Recomendaciones para ti
                    </h2>
                    <div class="space-y-4">
                        @forelse($recommendedBooks as $book)
                            <a href="{{ route('shop.show', $book->id) }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group flex items-center gap-6">
                                <!-- Imagen miniatura -->
                                <div class="w-20 h-28 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 shadow-sm border border-gray-200">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                </div>
                                <!-- Datos -->
                                <div>
                                    <h4 class="font-semibold text-lg text-gray-900 group-hover:text-[#744E36] transition-colors">{{ $book->title }}</h4>
                                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mt-1">{{ $book->genre ?: 'Aventura' }}</p>
                                    <p class="text-lg font-black text-gray-900 mt-2">{{ number_format($book->price, 2) }} €</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 italic">No hay recomendaciones disponibles en este momento.</p>
                        @endforelse
                    </div>
                </section>

                <!-- Columna Derecha: Historias de otros Autores (Gratis) -->
                <section>
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="text-green-500">📖</span> Historias Gratuitas
                    </h2>
                    <div class="space-y-4">
                        @forelse($freeStories as $story)
                            <a href="{{ route('stories.show', $story->id) }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group flex items-center gap-6">
                                <!-- Imagen/Icono miniatura -->
                                <div class="w-20 h-28 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 shadow-sm border border-gray-200">
                                    <img src="{{ $story->cover_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover">
                                </div>
                                <!-- Datos -->
                                <div class="flex-grow">
                                    <h4 class="font-semibold text-lg text-gray-900 group-hover:text-[#744E36] transition-colors">{{ $story->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">Por <span class="font-bold">{{ $story->user->name ?? 'Anónimo' }}</span></p>
                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-black uppercase rounded">Gratis</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="bg-white p-8 rounded-2xl border border-dashed border-gray-300 text-center">
                                <p class="text-gray-500">No hay historias gratuitas de otros autores disponibles aún.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

            </div>

            <!-- 3. Historias del autor-->
            @if(auth()->user()->role === 'author')
            <section class="pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-800">Tus Historias Originales</h2>
                    <a href="{{ route('stories.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition">Gestionar &rarr;</a>
                </div>
                
                @if($myStories->isEmpty())
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                        <p class="text-gray-500 mb-4">Aún no has escrito ninguna historia.</p>
                        <a href="{{ route('stories.create') }}" class="inline-block px-6 py-2 text-white font-bold rounded-full transition-colors" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                            Crear mi primera historia
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($myStories as $story)
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:border-[#744E36] transition-colors">
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $story->title }}</h3>
                                    <p class="text-xs text-gray-500 line-clamp-3">{{ $story->description }}</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                    <a href="{{ route('stories.show', $story->id) }}" class="text-sm font-bold" style="color: #744E36;">Editar</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            @endif

        </div>
    </div>
</x-app-layout>