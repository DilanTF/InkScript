<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex flex-col mb-8 text-center md:text-left">
                <a href="{{ route('stories.show', $story) }}" class="text-sm font-bold hover:underline mb-3 inline-flex items-center justify-center md:justify-start w-max mx-auto md:mx-0" style="color: #744E36;">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a la Obra
                </a>
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Editar Capítulo
                </h2>
                <p class="text-gray-500 mt-2 text-lg">Modificando la entrega de <span class="font-bold text-gray-800">"{{ $story->title }}"</span>.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-8 md:p-12">
                <form action="{{ route('stories.chapters.update', [$story, $chapter]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title" class="block font-bold text-sm uppercase tracking-wider mb-3" style="color: #744E36;">
                            Título del Capítulo
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $chapter->title) }}"
                               class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-xl shadow-sm px-6 py-4 text-xl font-semibold transition-colors text-gray-900" required>
                    </div>

                    <!-- NUEVA FILA: Volumen y Precio -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- CAMPO DEL VOLUMEN -->
                        <div>
                            <label class="block font-bold text-sm uppercase tracking-wider mb-2" style="color: #744E36;">
                                Volumen / Arco (Opcional)
                            </label>
                            <input type="text" name="volume_title" value="{{ old('volume_title', $chapter->volume_title) }}" placeholder="Ej: Volumen 1"
                                   class="w-full border-gray-200 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3 bg-gray-50 focus:bg-white transition-colors">
                        </div>

                        <!-- CAMPO DEL PRECIO -->
                        <div>
                            <label class="block font-bold text-sm uppercase tracking-wider mb-2" style="color: #744E36;">
                                Precio (En Euros)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-black">€</span>
                                </div>
                                <input type="number" name="price" value="{{ old('price', $chapter->price ?? '0.00') }}" step="0.01" min="0"
                                       class="w-full border-gray-200 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] pl-10 pr-4 py-3 bg-gray-50 focus:bg-white transition-colors">
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 font-bold">Déjalo en 0.00 para que sea gratis para todos.</p>
                        </div>
                    </div>

                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-2">
                            <label for="content" class="block font-bold text-sm uppercase tracking-wider" style="color: #744E36;">
                                Manuscrito
                            </label>
                        </div>
                        
                        <textarea name="content" id="content" rows="25"
                                  class="block w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-[#744E36] focus:ring-[#744E36] rounded-2xl shadow-inner px-6 py-6 resize-y transition-colors text-gray-800 leading-loose text-lg font-serif" 
                                  style="min-height: 400px;" required>{{ old('content', $chapter->content) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <a href="{{ route('stories.show', $story) }}" class="mr-6 text-sm font-bold text-gray-400 hover:text-gray-800 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="px-10 py-4 text-white font-bold rounded-full shadow-md transition-all transform hover:-translate-y-1 text-sm uppercase tracking-wider flex items-center gap-2" style="background-color: #744E36;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>