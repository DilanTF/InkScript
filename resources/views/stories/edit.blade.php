<x-app-layout>
    <!-- Fondo crema corporativo -->
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Encabezado con navegación de migas de pan -->
            <div class="flex flex-col mb-8">
                <a href="{{ route('stories.index') }}" class="text-sm font-bold hover:underline mb-3 inline-flex items-center w-max" style="color: #744E36;">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a Mis Historias
                </a>
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Configuración de la Obra
                </h2>
                <p class="text-gray-500 mt-2 text-lg">Modifica los detalles principales o reasigna los géneros de tu manuscrito.</p>
            </div>

            <!-- Contenedor principal estilo tarjeta doble -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                
                <!-- Columna Izquierda: Información y Metadatos -->
                <div class="md:w-1/3 bg-gray-50 p-8 border-b md:border-b-0 md:border-r border-gray-100 flex flex-col items-center text-center">
                    
                    <!-- Portada Provisional -->
                    <div class="w-32 h-48 bg-gradient-to-br from-[#744E36] to-[#5c3d2a] rounded-xl shadow-lg flex flex-col items-center justify-center mb-6 relative overflow-hidden p-3 border-2 border-white">
                        <svg class="w-8 h-8 text-white opacity-50 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-white font-bold text-[10px] uppercase tracking-widest text-center leading-tight relative z-10">{{ $story->title }}</span>
                    </div>
                    
                    <h3 class="font-bold text-gray-800 mb-1">Portada Provisional</h3>
                    <p class="text-xs text-gray-500 mb-8 leading-relaxed">La portada oficial a color se te pedirá cuando decidas publicar esta historia como un libro de pago en la tienda.</p>
                    
                    <!-- Metadatos de la historia -->
                    <div class="w-full bg-white p-5 rounded-2xl border border-gray-200 text-left shadow-sm">
                        <div class="mb-4">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Géneros actuales</p>
                            <p class="text-sm font-bold text-gray-800">{{ $story->genre ?? 'Sin asignar' }}</p>
                        </div>
                        <div class="pt-4 border-t border-gray-50">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Capítulos Escritos</p>
                            <p class="text-lg font-black text-gray-800">{{ $story->chapters()->count() ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Formulario de Edición -->
                <div class="md:w-2/3 p-8 md:p-12">
                    <form action="{{ route('stories.update', $story) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Campo: Título -->
                        <div class="mb-8">
                            <label for="title" class="block font-bold text-sm uppercase tracking-wider mb-3" style="color: #744E36;">
                                Título de la Obra
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $story->title) }}" 
                                   class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-xl shadow-sm px-4 py-3 text-lg font-semibold transition-colors text-gray-900" 
                                   required>
                            @error('title')
                                <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Selección de Géneros (NUEVO) -->
                        <div class="mb-8">
                            <label class="block font-bold text-sm uppercase tracking-wider mb-3" style="color: #744E36;">
                                Modificar Categorías / Géneros
                            </label>
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($genres as $genre)
                                    <label class="flex items-center space-x-3 cursor-pointer group bg-gray-50 border border-gray-200 p-3 rounded-xl hover:border-[#744E36] hover:bg-white transition-all shadow-sm">
                                        <input type="checkbox" name="genres[]" value="{{ $genre }}" 
                                               class="w-5 h-5 rounded border-gray-300 text-[#744E36] focus:ring-[#744E36] transition-colors cursor-pointer"
                                               {{ (is_array(old('genres', $selectedGenres)) && in_array($genre, old('genres', $selectedGenres))) ? 'checked' : '' }}>
                                        <span class="text-gray-700 font-bold group-hover:text-[#744E36] transition-colors text-sm">{{ $genre }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('genres')
                                <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Sinopsis -->
                        <div class="mb-10">
                            <label for="description" class="block font-bold text-sm uppercase tracking-wider mb-2" style="color: #744E36;">
                                Sinopsis / Contraportada
                            </label>
                            <p class="text-xs text-gray-500 mb-3 font-medium">Un buen resumen es clave para atrapar a tus futuros lectores. Genera intriga sin revelar el gran final.</p>
                            <textarea name="description" id="description" rows="5" 
                                      class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-xl shadow-sm px-4 py-3 resize-none transition-colors text-gray-800 leading-relaxed" 
                                      required>{{ old('description', $story->description) }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                            <a href="{{ route('stories.index') }}" class="mr-6 text-sm font-bold text-gray-400 hover:text-gray-800 transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="px-8 py-3 text-white font-bold rounded-full shadow-md transition-all transform hover:-translate-y-1 hover:shadow-lg text-sm uppercase tracking-wider flex items-center gap-2" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>