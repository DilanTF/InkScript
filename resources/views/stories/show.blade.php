<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 shadow-sm rounded-2xl flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gradient-to-r from-[#744E36] to-[#5c3d2a] rounded-3xl shadow-lg p-10 md:p-16 relative overflow-hidden flex flex-col md:flex-row items-center gap-10">
                <svg class="absolute right-0 top-0 text-white opacity-5 w-64 h-64 transform translate-x-16 -translate-y-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                
                <div class="flex-grow z-10 text-center md:text-left">
                    
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start mb-4">
                        <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold uppercase tracking-widest rounded-full backdrop-blur-sm border border-white/30 inline-block">
                            Obra Original
                        </span>
                        
                        @if($story->genre)
                            @foreach(explode(', ', $story->genre) as $g)
                                <span class="px-3 py-1 bg-amber-500/20 text-amber-100 text-xs font-bold uppercase tracking-widest rounded-full backdrop-blur-sm border border-amber-500/30 inline-block">
                                    {{ trim($g) }}
                                </span>
                            @endforeach
                        @endif
                    </div>

                    <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                        {{ $story->title }}
                    </h1>
                    <p class="text-white/80 text-lg flex items-center justify-center md:justify-start gap-2">
                        <span>Por <strong>{{ $story->user->name ?? 'Autor Desconocido' }}</strong></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
                        <span>{{ $story->chapters()->count() }} Capítulos</span>
                    </p>
                    
                    @if(auth()->check() && auth()->id() !== $story->user_id)
                        <div class="mt-8 flex justify-center md:justify-start">
                            <form action="{{ route('stories.follow', $story) }}" method="POST">
                                @csrf
                                @if(auth()->user()->followedStories->contains($story->id))
                                    <button type="submit" class="px-6 py-2.5 bg-white/20 text-white font-bold rounded-full hover:bg-red-500/80 transition-all backdrop-blur-sm border border-white/50 flex items-center gap-2 shadow-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                        Siguiendo
                                    </button>
                                @else
                                    <button type="submit" class="px-6 py-2.5 bg-white text-[#744E36] font-black rounded-full hover:bg-gray-100 transition-all shadow-lg flex items-center gap-2 transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        Seguir Historia
                                    </button>
                                @endif
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="lg:w-1/3 space-y-8">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4 mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                            Sinopsis
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $story->description }}
                        </p>
                    </div>

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

                                @if($story->chapters()->count() > 0)
                                    <div class="pt-4 border-t border-[#744E36]/20 mt-4">
                                        <button type="button" onclick="document.getElementById('publishModal').classList.remove('hidden')" class="flex items-center justify-center w-full px-4 py-3 bg-gradient-to-r from-amber-500 to-yellow-500 text-white font-bold rounded-xl shadow-md hover:from-amber-600 hover:to-yellow-600 transition-colors gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Publicar en Tienda
                                        </button>
                                    </div>

                                    <div id="publishModal" class="hidden fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                            
                                            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('publishModal').classList.add('hidden')"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-8 relative z-10 border border-gray-100">
                                                <form action="{{ route('stories.sell', $story) }}" method="POST">
                                                    @csrf
                                                    
                                                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-amber-100 rounded-full mb-6 shadow-inner">
                                                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                    
                                                    <div class="text-center">
                                                        <h3 class="text-2xl font-black leading-6 text-gray-900" id="modal-title" style="font-family: 'Instrument Sans', sans-serif;">
                                                            Lanzar al Mercado
                                                        </h3>
                                                        <p class="text-sm text-gray-500 mt-3 leading-relaxed">
                                                            Estás a punto de publicar <strong>"{{ $story->title }}"</strong> como un E-book en la tienda principal de InkScript. Establece los detalles de venta a continuación.
                                                        </p>
                                                    </div>

                                                    <div class="mt-8 space-y-6">
                                                        <div>
                                                            <label for="price" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Precio de Venta</label>
                                                            <div class="relative rounded-xl shadow-sm">
                                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500 font-black sm:text-lg">€</span>
                                                                </div>
                                                                <input type="number" name="price" id="price" step="0.01" min="0.99" value="9.99" class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 pr-4 py-3 sm:text-lg border-gray-200 rounded-xl font-black text-gray-900 bg-gray-50 transition-colors" required>
                                                            </div>
                                                            <p class="text-xs text-gray-400 mt-2 font-medium">El precio mínimo permitido en la plataforma es de 0.99€.</p>
                                                        </div>

                                                        <div>
                                                            <label for="genre" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Género Literario Principal</label>
                                                            <select name="genre" id="genre" class="focus:ring-amber-500 focus:border-amber-500 block w-full px-4 py-3 sm:text-base border-gray-200 rounded-xl font-bold text-gray-700 bg-gray-50 transition-colors cursor-pointer" required>
                                                                <option value="Fantasía">Fantasía</option>
                                                                <option value="Ciencia Ficción">Ciencia Ficción</option>
                                                                <option value="Romance">Romance</option>
                                                                <option value="Terror">Terror</option>
                                                                <option value="Misterio">Misterio</option>
                                                                <option value="Aventura">Aventura</option>
                                                                <option value="Histórica">Histórica</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mt-10 sm:flex sm:flex-row-reverse gap-3">
                                                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-full border border-transparent px-8 py-3 bg-gradient-to-r from-amber-500 to-yellow-500 text-base font-bold text-white shadow-md hover:from-amber-600 hover:to-yellow-600 sm:w-auto sm:text-sm transition-all transform hover:-translate-y-0.5">
                                                            Confirmar y Publicar
                                                        </button>
                                                        <button type="button" onclick="document.getElementById('publishModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center items-center rounded-full border border-gray-200 px-8 py-3 bg-white text-base font-bold text-gray-600 shadow-sm hover:bg-gray-50 hover:text-gray-900 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                                                            Cancelar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 pb-6 mb-6 gap-4">
                            <h2 class="text-2xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                                Índice de Capítulos
                            </h2>
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">{{ $story->chapters()->count() }} Publicados</span>
                        </div>

                        @if($story->chapters->isEmpty())
                            <div class="text-center py-16 px-4">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Próximamente</h4>
                                <p class="text-gray-500 max-w-md mx-auto">
                                    @if(auth()->id() === $story->user_id)
                                        Aún no has escrito ningún capítulo. ¡Usa el botón de la izquierda para comenzar!
                                    @else
                                        El autor está trabajando en el primer capítulo. ¡Vuelve pronto!
                                    @endif
                                </p>
                            </div>
                        @else
                            <div class="mb-8 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" id="chapterSearch" onkeyup="filterChapters()" placeholder="Buscar capítulo por número o título..." 
                                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border-transparent rounded-xl focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] transition-colors text-sm font-medium text-gray-800 placeholder-gray-400">
                            </div>

                            @php
                                $groupedChapters = $story->chapters->groupBy(function($chapter) {
                                    return $chapter->volume_title ?: 'Capítulos Generales';
                                });
                            @endphp

                            <div class="space-y-6" id="chaptersContainer">
                                @foreach($groupedChapters as $volumeName => $chapters)
                                    <details class="volume-group group" open>
                                        <summary class="flex justify-between items-center bg-[#F9F7F2] p-4 rounded-xl cursor-pointer list-none border border-[#744E36]/10 hover:border-[#744E36]/30 transition-colors">
                                            <h3 class="font-black text-gray-900 text-lg uppercase tracking-wider" style="font-family: 'Instrument Sans', sans-serif;">
                                                {{ $volumeName }} <span class="text-gray-400 text-sm font-bold ml-2">({{ $chapters->count() }})</span>
                                            </h3>
                                            <span class="transition group-open:rotate-180">
                                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><polyline points="6 9 12 15 18 9"/></svg>
                                            </span>
                                        </summary>
                                        
                                        <div class="mt-4 space-y-3 pl-2 sm:pl-4">
                                            @foreach($chapters as $index => $chapter)
                                                <a href="{{ route('stories.chapters.show', [$story, $chapter]) }}" 
                                                   class="chapter-item group/item flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:border-[#744E36]/30 hover:bg-white transition-all duration-300"
                                                   data-title="capitulo {{ $index + 1 }} {{ strtolower($chapter->title) }}">
                                                    
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-10 h-10 rounded-full bg-gray-50 group-hover/item:bg-[#F9F7F2] flex items-center justify-center text-sm font-black text-gray-400 group-hover/item:text-[#744E36] transition-colors border border-gray-100 shadow-sm">
                                                            {{ $index + 1 }}
                                                        </div>
                                                        <div>
                                                            <h4 class="text-base font-bold text-gray-900 group-hover/item:text-[#744E36] transition-colors">
                                                                {{ $chapter->title }}
                                                            </h4>
                                                            <p class="text-[11px] text-gray-400 mt-1 font-bold uppercase tracking-widest flex items-center gap-1">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                {{ $chapter->created_at->format('d M, Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="px-4 py-2 rounded-full bg-gray-50 text-gray-600 text-xs font-bold group-hover/item:bg-[#744E36] group-hover/item:text-white transition-colors flex items-center gap-2">
                                                        Leer
                                                        <svg class="w-4 h-4 transform group-hover/item:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function filterChapters() {
            let input = document.getElementById('chapterSearch').value.toLowerCase();
            let volumes = document.querySelectorAll('.volume-group');

            volumes.forEach(volume => {
                let chaptersInVolume = volume.querySelectorAll('.chapter-item');
                let hasVisibleChapters = false;

                chaptersInVolume.forEach(chapter => {
                    let title = chapter.getAttribute('data-title');
                    if (title.includes(input)) {
                        chapter.style.display = 'flex';
                        hasVisibleChapters = true;
                    } else {
                        chapter.style.display = 'none';
                    }
                });

                // Ocultar el volumen entero si no tiene capítulos que coincidan
                volume.style.display = hasVisibleChapters ? 'block' : 'none';
                
                // Abrir el acordeón si se está buscando algo
                if(input !== '' && hasVisibleChapters) {
                    volume.setAttribute('open', 'open');
                }
            });
        }
    </script>
</x-app-layout>