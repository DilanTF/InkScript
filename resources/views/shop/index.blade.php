<x-app-layout>
    <!-- Fondo crema corporativo de InkScript -->
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Encabezado elegante de la Tienda -->
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                    Librería InkScript
                </h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Explora nuestro catálogo, descubre a los autores de la comunidad y encuentra tu próxima gran lectura.</p>
            </div>

            <!-- Alertas de éxito o error -->
            @if(session('error'))
                <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 shadow-sm rounded-2xl flex items-center max-w-3xl mx-auto">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Cuadrícula de Libros -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($books as $book)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group transform hover:-translate-y-1">
                        
                        <!-- Portada del Libro -->
                        <div class="h-64 bg-gray-100 relative overflow-hidden flex items-center justify-center">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <!-- Portada Provisional Premium (Diseño de tapa dura) -->
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#744E36] to-[#5c3d2a] text-white p-6 relative">
                                    <svg class="absolute right-0 bottom-0 text-white opacity-10 w-32 h-32 transform translate-x-8 translate-y-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    
                                    <span class="font-black text-center uppercase tracking-widest opacity-90 text-sm leading-tight z-10" style="font-family: 'Instrument Sans', sans-serif;">
                                        {{ $book->title }}
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Etiquetas Flotantes (Formato y Disponibilidad) -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                @if($book->is_digital)
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-black uppercase tracking-wider rounded-full shadow-sm text-indigo-700 border border-white">Digital</span>
                                @else
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-black uppercase tracking-wider rounded-full shadow-sm border border-white" style="color: #744E36;">Físico</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Información del Libro -->
                        <div class="p-6 flex flex-col flex-grow justify-between">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest mb-2 text-gray-400">
                                    {{ $book->genre ?: 'Ficción General' }}
                                </p>
                                <h3 class="font-bold text-xl text-gray-900 leading-tight group-hover:text-[#744E36] transition-colors line-clamp-2" style="font-family: 'Instrument Sans', sans-serif;">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-3 line-clamp-2 leading-relaxed">
                                    {{ $book->description }}
                                </p>
                            </div>
                            
                            <!-- Pie de tarjeta: Precio y Acción -->
                            <div class="mt-6 pt-4 border-t border-gray-50 flex flex-col xl:flex-row items-center justify-between gap-4">
                                <div class="flex flex-col w-full xl:w-auto text-center xl:text-left">
                                    <span class="text-2xl font-black text-gray-900">{{ number_format($book->price, 2) }} €</span>
                                    @if(!$book->is_digital && $book->stock <= 0)
                                        <span class="text-[10px] font-bold text-red-500 uppercase tracking-widest mt-1">Agotado</span>
                                    @endif
                                </div>
                                
                                <a href="{{ route('shop.show', $book->id) }}" class="w-full xl:w-auto px-5 py-2.5 text-white text-sm font-bold rounded-full transition-all shadow-md hover:shadow-lg text-center whitespace-nowrap" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <!-- Estado Vacío -->
                    <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center max-w-2xl mx-auto my-10">
                        <div class="w-32 h-32 mx-auto mb-8 relative">
                            <div class="absolute inset-0 bg-[#F9F7F2] rounded-full flex items-center justify-center">
                                <svg class="w-16 h-16" style="color: #744E36;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Catálogo en preparación</h3>
                        <p class="text-gray-500 mb-2 text-lg leading-relaxed">Aún no hemos añadido libros a nuestra tienda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>