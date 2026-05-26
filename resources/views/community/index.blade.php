<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                    Comunidad InkScript
                </h2>
                <p class="text-gray-500 text-lg">Sumérgete en miles de historias publicadas capítulo a capítulo por autores de todo el mundo.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- PANEL LATERAL: FILTROS -->
                <div class="lg:w-1/4">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-semibold text-lg text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">Filtros</h3>
                            <!-- El botón "Limpiar" también aparece si marcamos estados -->
                            @if(!empty($selectedGenres) || !empty($selectedStatuses) || $searchTerm)
                                <a href="{{ route('community.index') }}" class="text-xs font-bold text-red-500 hover:text-red-700">Limpiar</a>
                            @endif
                        </div>
                        
                        <form action="{{ route('community.index') }}" method="GET" id="filter-form">
                            <!-- Buscador -->
                            <div class="mb-6 relative">
                                <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Buscar historia o autor..." 
                                       class="w-full border-gray-200 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] pl-10 py-2.5 text-sm bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>

                            <!-- Checkboxes de Estado -->
                            <div class="mb-6 pb-6 border-b border-gray-100">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Estado</h4>
                                <div class="space-y-3">
                                    @foreach($allStatuses as $status)
                                        <label class="flex items-center space-x-3 cursor-pointer group">
                                            <input type="checkbox" name="statuses[]" value="{{ $status }}" 
                                                   {{ in_array($status, $selectedStatuses ?? []) ? 'checked' : '' }}
                                                   onchange="document.getElementById('filter-form').submit()"
                                                   class="w-5 h-5 rounded border-gray-300 text-[#744E36] focus:ring-[#744E36] transition-colors cursor-pointer">
                                            <span class="text-gray-700 font-medium group-hover:text-[#744E36] transition-colors text-sm">{{ $status }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Checkboxes de Géneros -->
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Géneros</h4>
                                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                    @foreach($allGenres as $genre)
                                        <label class="flex items-center space-x-3 cursor-pointer group">
                                            <input type="checkbox" name="genres[]" value="{{ $genre }}" 
                                                    {{ in_array($genre, $selectedGenres ?? []) ? 'checked' : '' }}
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

                <!-- RESULTADOS DE LA COMUNIDAD -->
                <div class="lg:w-3/4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($stories as $story)
                            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:border-[#744E36]/30 transition-all flex flex-col justify-between">
                                <div>
                                    <div class="flex flex-wrap gap-2 items-start mb-4">
                                        @php
                                            // Cogemos solo el primer género para que la tarjeta no se vea saturada
                                            $firstGenre = $story->genre ? explode(', ', $story->genre)[0] : 'General';
                                        @endphp
                                        <span class="px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-wider rounded-full">{{ $firstGenre }}</span>
                                        
                                        @if($story->status === 'Finalizada')
                                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full border border-emerald-100">Finalizada</span>
                                        @elseif($story->status === 'Pausada')
                                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 bg-gray-50 px-2 py-1 rounded-full border border-gray-200">Pausada</span>
                                        @else
                                            <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 px-2 py-1 rounded-full border border-blue-100">En Emisión</span>
                                        @endif
                                    </div>
                                    
                                    <h4 class="font-black text-xl text-gray-900 leading-tight mb-2" style="font-family: 'Instrument Sans', sans-serif;">{{ $story->title }}</h4>
                                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">{{ $story->description }}</p>
                                </div>
                                <div class="flex items-center justify-between border-t border-gray-50 pt-4 mt-auto">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">{{ substr($story->user->name, 0, 1) }}</div>
                                        <span class="text-sm font-bold text-gray-700">{{ $story->user->name }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $story->chapters()->count() }} Cap.</span>
                                        <a href="{{ route('stories.show', $story->id) }}" class="text-[#744E36] font-bold text-sm hover:underline flex items-center gap-1">
                                            Leer <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white p-12 text-center rounded-3xl border border-dashed border-gray-200">
                                <p class="text-gray-500 text-lg">No hay historias con estos filtros.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>