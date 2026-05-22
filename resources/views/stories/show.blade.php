<x-app-layout>
    <!-- Fondo crema corporativo -->
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Alertas de éxito -->
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 shadow-sm rounded-2xl flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Cabecera Hero (Portada de la Obra) -->
            <div class="bg-gradient-to-r from-[#744E36] to-[#5c3d2a] rounded-3xl shadow-lg p-10 md:p-16 relative overflow-hidden flex flex-col md:flex-row items-center gap-10">
                <!-- Marca de agua decorativa -->
                <svg class="absolute right-0 top-0 text-white opacity-5 w-64 h-64 transform translate-x-16 -translate-y-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                
                <div class="flex-grow z-10 text-center md:text-left">
                    <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold uppercase tracking-widest rounded-full backdrop-blur-sm border border-white/30 mb-4 inline-block">
                        Obra Original
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                        {{ $story->title }}
                    </h1>
                    <p class="text-white/80 text-lg flex items-center justify-center md:justify-start gap-2">
                        <span>Por <strong>{{ $story->user->name ?? 'Autor Desconocido' }}</strong></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
                        <span>{{ $story->chapters()->count() }} Capítulos</span>
                    </p>
                </div>
            </div>

            <!-- Contenido Principal: Dos Columnas -->
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Columna Izquierda: Sinopsis y Acciones de Autor -->
                <div class="lg:w-1/3 space-y-8">
                    <!-- Sinopsis -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4 mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                            Sinopsis
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $story->description }}
                        </p>
                    </div>

                    <!-- Panel de Autor (SOLO VISIBLE SI ERES EL DUEÑO) -->
                    @if(auth()->id() === $story->user_id)
                        <div class="bg-[#FDFBF7] rounded-3xl shadow-sm border-2 border-[#744E36]/20 p-8">
                            <h3 class="text-lg font-bold text-[#744E36] mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Herramientas de Autor
                            </h3>
                            
                            <div class="space-y-4">
                                <a href="{{ route('stories.chapters.create', $story) }}" class="flex items-center justify-center w-full px-4 py-3 bg-[#744E36] text-white font-bold rounded-xl shadow-sm hover:bg-[#5c3d2a] transition-colors gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Añadir Nuevo Capítulo
                                </a>
                                
                                <a href="{{ route('stories.edit', $story) }}" class="flex items-center justify-center w-full px-4 py-3 bg-white text-[#744E36] border border-[#744E36] font-bold rounded-xl shadow-sm hover:bg-gray-50 transition-colors gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Editar Sinopsis
                                </a>

                                <!-- Lógica de Venta: Solo si tiene al menos 1 capítulo se puede vender -->
                                @if($story->chapters()->count() > 0)
                                    <form action="{{ route('stories.sell', $story) }}" method="POST" class="pt-4 border-t border-[#744E36]/20 mt-4">
                                        @csrf
                                        <!-- Simulamos que el autor le pone un precio a su libro -->
                                        <input type="hidden" name="price" value="14.99">
                                        <input type="hidden" name="genre" value="Ficción Autor">
                                        <button type="submit" class="flex items-center justify-center w-full px-4 py-3 bg-gradient-to-r from-amber-500 to-yellow-500 text-white font-bold rounded-xl shadow-md hover:from-amber-600 hover:to-yellow-600 transition-colors gap-2" onclick="return confirm('¿Quieres empaquetar esta historia y enviarla a la Tienda por 14.99€?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Publicar en Tienda
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Columna Derecha: Lista de Capítulos -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-6">
                            <h2 class="text-2xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                                Índice de Capítulos
                            </h2>
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">{{ $story->chapters()->count() }} Publicados</span>
                        </div>

                        @if($story->chapters->isEmpty())
                            <!-- Estado vacío de Capítulos -->
                            <div class="text-center py-16 px-4">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Próximamente</h4>
                                <p class="text-gray-500 max-w-md mx-auto">
                                    @if(auth()->id() === $story->user_id)
                                        Aún no has escrito ningún capítulo para esta historia. ¡Usa el botón de la izquierda para comenzar!
                                    @else
                                        El autor está trabajando en el primer capítulo. ¡Vuelve pronto para comenzar la aventura!
                                    @endif
                                </p>
                            </div>
                        @else
                            <!-- Lista interactiva de Capítulos -->
                            <div class="space-y-4">
                                @foreach($story->chapters as $index => $chapter)
                                    <a href="{{ route('stories.chapters.show', [$story, $chapter]) }}" class="group flex items-center justify-between p-5 rounded-2xl border border-gray-100 hover:border-[#744E36]/30 hover:bg-[#F9F7F2]/50 transition-all duration-300">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full bg-gray-50 group-hover:bg-white flex items-center justify-center text-lg font-black text-gray-400 group-hover:text-[#744E36] transition-colors border border-gray-100 shadow-sm">
                                                {{ $index + 1 }}
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-900 group-hover:text-[#744E36] transition-colors">
                                                    {{ $chapter->title }}
                                                </h4>
                                                <p class="text-xs text-gray-400 mt-1 font-medium flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    Publicado {{ $chapter->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Botón Leer -->
                                        <div class="px-5 py-2 rounded-full bg-gray-100 text-gray-600 text-sm font-bold group-hover:bg-[#744E36] group-hover:text-white transition-colors flex items-center gap-2">
                                            Leer
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>