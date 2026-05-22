<x-app-layout>
    <!-- Fondo crema corporativo -->
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Encabezado elegante -->
            <div class="mb-10 text-center">
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Tu Carrito de Compras
                </h2>
                <p class="text-gray-500 mt-2 text-lg">Revisa tus elecciones antes de finalizar el pedido.</p>
            </div>

            <!-- Mensajes de éxito al borrar o actualizar -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 shadow-sm rounded-2xl flex items-center max-w-3xl mx-auto">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-transparent">
                @if(count($cart) > 0)
                    <div class="flex flex-col lg:flex-row gap-8">
                        
                        <!-- Columna Izquierda: Listado de Libros -->
                        <div class="lg:w-2/3">
                            <!-- Tarjeta principal para la lista -->
                            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8">
                                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                                    <h3 class="text-xl font-bold text-gray-800" style="color: #744E36;">Artículos ({{ count($cart) }})</h3>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Vaciar Carrito
                                        </button>
                                    </form>
                                </div>

                                <div class="space-y-6">
                                    @foreach($cart as $id => $details)
                                        <div class="flex items-center gap-6 p-4 rounded-2xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100 group">
                                            <!-- Imagen de Portada -->
                                            <div class="w-24 h-32 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden shadow-sm border border-gray-200">
                                                @if($details['image'])
                                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex flex-col items-center justify-center p-2 bg-gradient-to-br from-[#744E36] to-[#5c3d2a] text-white opacity-90">
                                                        <svg class="w-6 h-6 mb-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                        <span class="text-[9px] font-bold uppercase text-center tracking-wider leading-tight">{{ $details['title'] }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Detalles del Producto -->
                                            <div class="flex-grow flex flex-col justify-between h-32 py-1">
                                                <div>
                                                    <div class="flex justify-between items-start">
                                                        <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $details['title'] }}</h4>
                                                        <span class="font-black text-gray-900 text-xl">{{ number_format($details['price'], 2) }}€</span>
                                                    </div>
                                                    <p class="text-xs font-bold uppercase mt-2 tracking-wider" style="color: #744E36;">
                                                        {{ $details['is_digital'] ? 'E-book (Digital)' : 'Libro Físico' }}
                                                    </p>
                                                </div>

                                                <div class="flex items-end justify-between">
                                                    <!-- Cantidad interactiva -->
                                                    <div class="flex items-center space-x-3">
                                                        <span class="text-sm font-medium text-gray-500">Cant:</span>
                                                        <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" 
                                                                   class="w-16 h-8 text-sm border-gray-300 rounded-lg text-center focus:ring-[#744E36] focus:border-[#744E36] shadow-sm" 
                                                                   onchange="this.form.submit()">
                                                        </form>
                                                    </div>

                                                    <!-- Eliminar -->
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition flex items-center justify-center p-2 rounded-full hover:bg-red-50" title="Eliminar del carrito">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha: Resumen de Pago -->
                        <div class="lg:w-1/3">
                            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm sticky top-24">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6" style="font-family: 'Instrument Sans', sans-serif;">Resumen del pedido</h3>
                                
                                <div class="space-y-4 border-b border-gray-100 pb-6 text-gray-600">
                                    <div class="flex justify-between items-center text-lg">
                                        <span>Subtotal</span>
                                        <span class="font-medium text-gray-900">{{ number_format($total, 2) }}€</span>
                                    </div>
                                    <div class="flex justify-between items-center text-lg">
                                        <span>Envío</span>
                                        <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded text-sm">GRATIS</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm text-gray-400">
                                        <span>Impuestos aplicables</span>
                                        <span>Calculados al pagar</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-end mt-6 mb-8">
                                    <span class="text-xl font-bold text-gray-900">Total</span>
                                    <span class="text-4xl font-black text-gray-900">{{ number_format($total, 2) }}€</span>
                                </div>

                                <form action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-white font-bold py-4 px-6 rounded-full shadow-lg transition-all transform active:scale-95 flex items-center justify-center group text-lg" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                                        <span>Pagar de forma segura</span>
                                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Garantías visuales (Confianza) -->
                                <div class="mt-8 flex flex-col items-center">
                                    <div class="flex items-center justify-center gap-2 text-xs font-medium text-gray-500 mb-4">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Transacción encriptada SSL
                                    </div>
                                    <div class="flex gap-4 grayscale opacity-50 justify-center w-full border-t border-gray-100 pt-6">
                                        <i class="fa-brands fa-cc-visa text-3xl hover:grayscale-0 hover:opacity-100 transition"></i>
                                        <i class="fa-brands fa-cc-mastercard text-3xl hover:grayscale-0 hover:opacity-100 transition"></i>
                                        <i class="fa-brands fa-cc-paypal text-3xl hover:grayscale-0 hover:opacity-100 transition"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Carrito Vacío Premium -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center max-w-2xl mx-auto my-10">
                        <div class="w-32 h-32 mx-auto mb-8 relative">
                            <!-- Ícono de cesta vacío con estilo corporativo -->
                            <div class="absolute inset-0 bg-[#F9F7F2] rounded-full flex items-center justify-center">
                                <svg class="w-16 h-16" style="color: #744E36;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Tu cesta está vacía</h3>
                        <p class="text-gray-500 mb-10 text-lg leading-relaxed">No hay libros en tu carrito de compras. Sumérgete en nuestro catálogo y descubre mundos increíbles escritos por la comunidad.</p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-10 py-4 text-white font-bold rounded-full shadow-md transition-all transform hover:-translate-y-1 hover:shadow-lg text-lg" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                            Explorar Obras Literarias
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>