<x-app-layout>
    <!-- Fondo crema corporativo -->
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Encabezado con navegación de migas de pan -->
            <div class="flex flex-col mb-8 text-center md:text-left">
                <a href="{{ route('stories.show', $story) }}" class="text-sm font-bold hover:underline mb-3 inline-flex items-center justify-center md:justify-start w-max mx-auto md:mx-0" style="color: #744E36;">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a la Obra
                </a>
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Nuevo Capítulo
                </h2>
                <p class="text-gray-500 mt-2 text-lg">Añadiendo una nueva entrega a <span class="font-bold text-gray-800">"{{ $story->title }}"</span>.</p>
            </div>

            <!-- Contenedor del Editor -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-8 md:p-12">
                <form action="{{ route('stories.chapters.store', $story) }}" method="POST">
                    @csrf

                    <!-- Campo: Título del Capítulo -->
                    <div class="mb-8">
                        <label for="title" class="block font-bold text-sm uppercase tracking-wider mb-3" style="color: #744E36;">
                            Título del Capítulo
                        </label>
                        <input type="text" name="title" id="title" placeholder="Ej: Capítulo 1: El Despertar"
                               class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-xl shadow-sm px-6 py-4 text-xl font-semibold transition-colors text-gray-900 placeholder-gray-300" 
                               required>
                        @error('title')
                            <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NUEVA FILA: Volumen y Precio -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Campo para el Volumen -->
                        <div>
                            <label class="block font-bold text-sm uppercase tracking-wider mb-2" style="color: #744E36;">
                                Volumen / Arco (Opcional)
                            </label>
                            <input type="text" name="volume_title" value="{{ old('volume_title') }}" placeholder="Ej: Volumen 1"
                                   class="w-full border-gray-200 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3 bg-gray-50 focus:bg-white transition-colors">
                        </div>

                        <!-- Campo para el Precio -->
                        <div>
                            <label class="block font-bold text-sm uppercase tracking-wider mb-2" style="color: #744E36;">
                                Precio (En Euros)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-black">€</span>
                                </div>
                                <input type="number" name="price" value="{{ old('price', '0.00') }}" step="0.01" min="0"
                                       class="w-full border-gray-200 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] pl-10 pr-4 py-3 bg-gray-50 focus:bg-white transition-colors">
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 font-bold">Déjalo en 0.00 para que sea gratis para todos.</p>
                        </div>
                    </div>

                    <!-- Campo: Contenido (El lienzo) -->
                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-2">
                            <label for="content" class="block font-bold text-sm uppercase tracking-wider" style="color: #744E36;">
                                Manuscrito
                            </label>
                            <span class="text-xs font-bold text-gray-400 bg-gray-100 px-2 py-1 rounded">Autoguardado desactivado</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-4 font-medium">Deja fluir tu imaginación. Puedes separar los párrafos usando la tecla Enter.</p>
                        
                        <!-- Textarea grande para escribir -->
                        <textarea name="content" id="content" rows="25" placeholder="Érase una vez..."
                                  class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-2xl shadow-inner px-6 py-6 resize-y transition-colors text-gray-800 leading-loose text-lg font-serif" 
                                  style="min-height: 400px;"
                                  required></textarea>
                        @error('content')
                            <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <a href="{{ route('stories.show', $story) }}" class="mr-6 text-sm font-bold text-gray-400 hover:text-gray-800 transition-colors">
                            Descartar
                        </a>
                        <button type="submit" class="px-10 py-4 text-white font-bold rounded-full shadow-md transition-all transform hover:-translate-y-1 hover:shadow-lg text-sm uppercase tracking-wider flex items-center gap-2" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Publicar Capítulo
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>