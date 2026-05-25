<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Botón Volver a Mi Panel -->
            <div class="flex items-center mb-2">
                <a href="{{ route('panel') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#744E36] transition-colors bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100 hover:shadow w-max">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a Mi Panel
                </a>
            </div>

            <!-- Encabezado elegante -->
            <div class="mb-10 text-center">
                <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-indigo-100 shadow-sm">
                    <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Mi Inventario Digital
                </h2>
                <p class="text-gray-500 mt-2 text-lg">Tu biblioteca personal de E-books listos para descargar.</p>
            </div>

            @if($inventory->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($inventory as $item)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col group">
                            
                            <!-- Portada -->
                            <div class="h-64 bg-gray-100 relative overflow-hidden flex items-center justify-center border-b border-gray-100">
                                @if($item->book->image)
                                    <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#744E36] to-[#5c3d2a] text-white p-6 relative">
                                        <svg class="absolute right-0 bottom-0 text-white opacity-10 w-32 h-32 transform translate-x-8 translate-y-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span class="font-black text-center uppercase tracking-widest opacity-90 text-sm leading-tight z-10" style="font-family: 'Instrument Sans', sans-serif;">{{ $item->book->title }}</span>
                                    </div>
                                @endif
                                
                                <!-- Etiqueta Formato -->
                                <span class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-black uppercase tracking-wider rounded-full shadow-sm text-indigo-700 border border-white">
                                    EPUB / PDF
                                </span>
                            </div>
                            
                            <!-- Info y Descarga -->
                            <div class="p-6 flex flex-col flex-grow justify-between">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2" style="font-family: 'Instrument Sans', sans-serif;">
                                        {{ $item->book->title }}
                                    </h3>
                                    <p class="text-[11px] font-bold text-gray-400 mt-2 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Adquirido: {{ $item->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                                
                                <div class="mt-6 pt-4 border-t border-gray-50">
                                    <a href="#" onclick="alert('Descargando archivo cifrado a tu dispositivo local...'); return false;" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-xl transition-all shadow-sm hover:bg-indigo-600 hover:text-white group-hover:border-indigo-600 border border-indigo-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Descargar Archivo
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado Vacío -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center max-w-2xl mx-auto my-10">
                    <p class="text-gray-500 mb-6 text-lg leading-relaxed">Aún no has adquirido ningún libro digital en nuestra tienda.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:underline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Explorar catálogo de la tienda
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>