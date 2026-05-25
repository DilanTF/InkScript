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
                    Nueva Obra Literaria
                </h2>
                <p class="text-gray-500 mt-2 text-lg">El primer paso para dar vida a tu próximo gran éxito.</p>
            </div>

            <!-- Contenedor principal estilo tarjeta doble -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                
                <!-- Columna Izquierda: Inspiración y Consejos -->
                <div class="md:w-1/3 bg-gradient-to-br from-[#744E36] to-[#5c3d2a] p-8 md:p-12 flex flex-col justify-center text-white relative overflow-hidden">
                    <svg class="absolute right-0 bottom-0 text-white opacity-10 w-48 h-48 transform translate-x-12 translate-y-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-6 backdrop-blur-sm border border-white/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black mb-4 leading-tight" style="font-family: 'Instrument Sans', sans-serif;">Toda gran historia empieza con una idea.</h3>
                        <p class="text-white/80 text-sm leading-relaxed mb-6">
                            Define el título, selecciona los géneros en los que encaja tu obra y escribe una sinopsis atrapante. Puedes elegir varios géneros a la vez para posicionar mejor tu historia en la comunidad.
                        </p>
                    </div>
                </div>

                <!-- Columna Derecha: Formulario de Creación -->
                <div class="md:w-2/3 p-8 md:p-12">
                    <form action="{{ route('stories.store') }}" method="POST">
                        @csrf

                        <!-- Campo: Título -->
                        <div class="mb-8">
                            <label for="title" class="block font-bold text-sm uppercase tracking-wider mb-3" style="color: #744E36;">
                                Título de la Obra
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Ej: Las Crónicas del Viento"
                                   class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-xl shadow-sm px-4 py-3 text-lg font-semibold transition-colors text-gray-900 placeholder-gray-400" 
                                   required autofocus>
                            @error('title')
                                <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Selección de Géneros (NUEVO) -->
                        <div class="mb-8">
                            <label class="block font-bold text-sm uppercase tracking-wider mb-3" style="color: #744E36;">
                                Categorías / Géneros (Elige al menos 1)
                            </label>
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($genres as $genre)
                                    <label class="flex items-center space-x-3 cursor-pointer group bg-gray-50 border border-gray-200 p-3 rounded-xl hover:border-[#744E36] hover:bg-white transition-all shadow-sm">
                                        <input type="checkbox" name="genres[]" value="{{ $genre }}" 
                                               class="w-5 h-5 rounded border-gray-300 text-[#744E36] focus:ring-[#744E36] transition-colors cursor-pointer"
                                               {{ (is_array(old('genres')) && in_array($genre, old('genres'))) ? 'checked' : '' }}>
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
                                Sinopsis Inicial
                            </label>
                            <p class="text-xs text-gray-500 mb-3 font-medium">Escribe un breve resumen para tener clara la premisa de tu historia.</p>
                            <textarea name="description" id="description" rows="5" placeholder="En un reino lejano donde la magia ha sido olvidada..."
                                      class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-xl shadow-sm px-4 py-3 resize-none transition-colors text-gray-800 leading-relaxed" 
                                      required>{{ old('description') }}</textarea>
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
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Crear Historia
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>