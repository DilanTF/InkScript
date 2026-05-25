<x-app-layout>
    <!-- Fondo crema corporativo -->
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
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <div class="text-center md:text-left">
                    <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                        Mis Historias
                    </h2>
                    <p class="text-gray-500 mt-2 text-lg">Tu estudio creativo. Escribe, edita y gestiona tus obras.</p>
                </div>
                
                <!-- Botón de Nueva Historia -->
                <a href="{{ route('stories.create') }}" class="inline-flex items-center px-8 py-3 text-white font-bold rounded-full shadow-md transition-all transform hover:-translate-y-1 hover:shadow-lg text-sm uppercase tracking-wider" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nueva Historia
                </a>
            </div>

            <!-- Mensaje de éxito -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 shadow-sm rounded-2xl flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($stories->isEmpty())
                <!-- Estado Vacío Premium (Empty State) -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center max-w-2xl mx-auto my-10">
                    <div class="w-32 h-32 mx-auto mb-8 relative">
                        <div class="absolute inset-0 bg-[#F9F7F2] rounded-full flex items-center justify-center">
                            <!-- Icono de pluma/escritura -->
                            <svg class="w-16 h-16" style="color: #744E36;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">El lienzo está en blanco</h3>
                    <p class="text-gray-500 mb-10 text-lg leading-relaxed">Aún no has creado ninguna historia. Toda gran aventura comienza con una primera palabra. ¿Estás listo para escribir la tuya?</p>
                    <a href="{{ route('stories.create') }}" class="inline-flex items-center px-10 py-4 text-white font-bold rounded-full shadow-md transition-all transform hover:-translate-y-1 hover:shadow-lg text-lg" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                        Empezar a escribir
                    </a>
                </div>
            @else
                <!-- Cuadrícula de Historias -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($stories as $story)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group transform hover:-translate-y-1">
                            
                            <!-- "Portada" decorativa de la tarjeta -->
                            <div class="h-40 bg-gradient-to-br from-[#744E36] to-[#5c3d2a] p-6 flex flex-col justify-end relative overflow-hidden">
                                <!-- Elemento decorativo de fondo -->
                                <svg class="absolute right-0 bottom-0 text-white opacity-10 w-32 h-32 transform translate-x-8 translate-y-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                
                                <h3 class="text-2xl font-black text-white leading-tight line-clamp-2 relative z-10" style="font-family: 'Instrument Sans', sans-serif;">
                                    {{ $story->title }}
                                </h3>
                            </div>
                            
                            <!-- Contenido de la tarjeta -->
                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <p class="text-gray-600 line-clamp-3 text-sm mb-6 leading-relaxed">
                                    {{ $story->description }}
                                </p>
                                
                                <!-- Botones de Acción (Footer de la tarjeta) -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
                                    
                                    <!-- Botón Principal: Gestionar/Leer -->
                                    <a href="{{ route('stories.show', $story) }}" class="text-sm font-bold flex items-center gap-2 transition-colors uppercase tracking-wider px-4 py-2 rounded-lg bg-gray-50 hover:bg-gray-100" style="color: #744E36;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        Gestionar
                                    </a>
                                    
                                    <!-- Acciones secundarias (Editar y Borrar) -->
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('stories.edit', $story) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-all" title="Editar detalles">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <form action="{{ route('stories.destroy', $story) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de querer borrar esta historia permanentemente? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-all" title="Borrar historia">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>