<x-app-layout>
    <div class="py-8 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row gap-8">

                <!-- 1. SIDEBAR -->
                <div class="w-full md:w-64 flex-shrink-0">
                    <div class="bg-[#744E36] rounded-3xl shadow-xl overflow-hidden sticky top-24">
                        <nav class="flex flex-col py-4">
                            <a href="{{ route('profile.edit') }}" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                Perfil
                            </a>
                            <a href="{{ route('panel') }}" class="px-8 py-4 text-white text-lg font-semibold bg-[#5c3d2a] border-l-4 border-white transition">
                                Mi Panel
                            </a>
                            <!-- NUEVO ENLACE AL INVENTARIO -->
                            <a href="{{ route('inventory.index') }}" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                Mi Inventario
                            </a>
                            <a href="{{ route('orders.index') }}" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                Mis Compras
                            </a>
                            
                            @if(auth()->user()->role === 'author')
                                <a href="{{ route('stories.index') }}" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                    Mis Publicaciones
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>

                <!-- 2. CONTENIDO PRINCIPAL -->
                <div class="flex-grow bg-white rounded-3xl shadow-sm p-8 md:p-10 border border-gray-100">
                    
                    <div class="mb-10 pb-6 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">Panel de Control</h2>
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-[#744E36] text-white text-sm font-bold rounded-full hover:bg-[#5c3d2a] transition shadow-md">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>

                    <div class="space-y-12">
                        
                        <!-- SECCIÓN 1: NOTIFICACIONES -->
                        <section>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2" style="font-family: 'Instrument Sans', sans-serif;">
                                <span class="text-amber-500">🔔</span> Actualizaciones de tus lecturas
                            </h3>

                            @if(isset($followedStories) && $followedStories->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($followedStories as $story)
                                        @php
                                            $latestChapter = $story->chapters->last();
                                        @endphp
                                        
                                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 flex flex-col justify-between hover:bg-white hover:border-[#744E36]/30 hover:shadow-sm transition-all group">
                                            <div class="flex items-start gap-4 mb-4">
                                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100 flex-shrink-0">
                                                    <svg class="w-5 h-5 text-[#744E36]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900 group-hover:text-[#744E36] transition-colors">{{ $story->title }}</h4>
                                                    @if($latestChapter)
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            Último: <span class="font-bold text-gray-700">{{ $latestChapter->title }}</span>
                                                        </p>
                                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $latestChapter->created_at->diffForHumans() }}</p>
                                                    @else
                                                        <p class="text-xs text-gray-400 mt-1 italic">Sin capítulos publicados.</p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('stories.show', $story) }}" class="w-full py-2 bg-white text-[#744E36] border border-gray-200 font-bold rounded-xl text-center text-xs group-hover:border-[#744E36] transition-colors">
                                                Ir a la historia
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 px-6 py-8 rounded-2xl border border-dashed border-gray-200 text-center">
                                    <p class="text-gray-500 text-sm mb-3">No sigues ninguna historia de la comunidad.</p>
                                    <a href="{{ route('community.index') }}" class="text-[#744E36] text-sm font-bold hover:underline">Explorar la Comunidad &rarr;</a>
                                </div>
                            @endif
                        </section>

                        <!-- SECCIÓN 2: DESCARGAS DIGITALES (LIMITADO A 5) -->
                        <section>
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2" style="font-family: 'Instrument Sans', sans-serif;">
                                <span class="text-indigo-500">☁️</span> Mis Descargas Recientes
                            </h3>

                            @if(isset($digitalPurchases) && $digitalPurchases->count() > 0)
                                <div class="space-y-3">
                                    @foreach($digitalPurchases as $item)
                                        <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0 shadow-sm border border-gray-300">
                                                    @if($item->book->image)
                                                        <img src="{{ asset('storage/' . $item->book->image) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full bg-[#744E36] flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900">{{ $item->book->title }}</h4>
                                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        Adquirido: {{ $item->created_at->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="#" onclick="alert('Funcionalidad de descarga de PDF en desarrollo.'); return false;" class="px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition-colors flex items-center gap-2 border border-indigo-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                <span class="hidden sm:inline">Descargar</span>
                                            </a>
                                        </div>
                                    @endforeach
                                    
                                    <!-- BOTÓN PARA VER TODO EL INVENTARIO -->
                                    <div class="pt-4 text-center">
                                        <a href="{{ route('inventory.index') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold text-sm hover:underline">
                                            Ver todo mi inventario completo
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="bg-gray-50 px-6 py-6 rounded-2xl border border-dashed border-gray-200 text-center">
                                    <p class="text-gray-500 text-sm">No has adquirido ningún E-book digital en la tienda.</p>
                                </div>
                            @endif
                        </section>

                        <!-- SECCIÓN 3: ACTIVIDAD COMO AUTOR -->
                        @if(auth()->user()->role === 'author')
                            <section>
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2 justify-between" style="font-family: 'Instrument Sans', sans-serif;">
                                    <div class="flex items-center gap-2">
                                        <span class="text-green-500">💬</span> Comentarios en tus Obras
                                    </div>
                                    <a href="{{ route('stories.index') }}" class="text-xs px-3 py-1.5 bg-[#744E36] text-white rounded-lg font-bold hover:bg-[#5c3d2a] transition shadow-sm flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Añadir Capítulo
                                    </a>
                                </h3>

                                @if(isset($receivedComments) && $receivedComments->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($receivedComments as $comment)
                                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative">
                                                <div class="flex items-start gap-4">
                                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-600 uppercase flex-shrink-0">
                                                        {{ substr($comment->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="flex items-baseline gap-2 mb-1">
                                                            <span class="font-bold text-gray-900 text-sm">{{ $comment->user->name }}</span>
                                                            <span class="text-xs text-gray-400">comentó en</span>
                                                            <a href="{{ route('stories.chapters.show', [$comment->chapter->story, $comment->chapter]) }}" class="text-xs font-bold text-[#744E36] hover:underline">
                                                                {{ $comment->chapter->story->title }} ({{ $comment->chapter->title }})
                                                            </a>
                                                        </div>
                                                        <p class="text-gray-600 text-sm italic border-l-2 border-gray-200 pl-3 py-1 my-2">"{{ $comment->content }}"</p>
                                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-gray-50 px-6 py-6 rounded-2xl border border-dashed border-gray-200 text-center">
                                        <p class="text-gray-500 text-sm">Aún no has recibido comentarios en tus historias.</p>
                                    </div>
                                @endif
                            </section>
                        @endif

                    </div>

                    <!-- Enlaces Rápidos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12 border-t border-gray-100 pt-8">
                        <a href="{{ route('shop.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-[#744E36] hover:shadow transition group cursor-pointer block">
                            <h4 class="font-bold text-gray-900 mb-2 group-hover:text-[#744E36] transition-colors flex items-center justify-between">
                                Explorar Novedades en Tienda
                                <svg class="w-5 h-5 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </h4>
                            <p class="text-sm text-gray-500">Descubre los libros y e-books más recientes añadidos al catálogo.</p>
                        </a>
                        
                        <a href="{{ route('community.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-[#744E36] hover:shadow transition group cursor-pointer block">
                            <h4 class="font-bold text-gray-900 mb-2 group-hover:text-[#744E36] transition-colors flex items-center justify-between">
                                Foro y Comunidad
                                <svg class="w-5 h-5 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </h4>
                            <p class="text-sm text-gray-500">Accede a las historias gratuitas y comenta con otros lectores de InkScript.</p>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>