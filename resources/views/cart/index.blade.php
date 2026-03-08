<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tu Carrito de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de éxito al borrar o actualizar -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                @if(count($cart) > 0)
                    <div class="flex flex-col lg:flex-row gap-12">
                        
                        <!-- Columna Izquierda: Listado de Libros -->
                        <div class="lg:w-2/3">
                            <div class="flex justify-between items-center mb-6 border-b pb-4">
                                <h3 class="text-lg font-bold text-gray-700">Artículos ({{ count($cart) }})</h3>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Vaciar Carrito</button>
                                </form>
                            </div>

                            <div class="space-y-6">
                                @foreach($cart as $id => $details)
                                    <div class="flex items-center gap-6 p-4 border rounded-xl hover:bg-gray-50 transition shadow-sm bg-white">
                                        <!-- Imagen de Portada -->
                                        <div class="w-20 h-28 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden shadow-sm border border-gray-100">
                                            @if($details['image'])
                                                <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase text-center p-2 bg-gradient-to-br from-gray-50 to-gray-100">
                                                    {{ $details['title'] }}
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Detalles del Producto -->
                                        <div class="flex-grow">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $details['title'] }}</h4>
                                                    <p class="text-xs text-indigo-500 font-bold uppercase mt-1 tracking-wider">
                                                        {{ $details['is_digital'] ? 'E-book (Digital)' : 'Libro Físico' }}
                                                    </p>
                                                </div>
                                                <span class="font-black text-gray-900">{{ number_format($details['price'], 2) }}€</span>
                                            </div>

                                            <div class="flex items-center justify-between mt-6">
                                                <!-- Cantidad -->
                                                <div class="flex items-center space-x-3 text-sm">
                                                    <span class="text-gray-500">Cantidad:</span>
                                                    <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" 
                                                               class="w-16 border-gray-300 rounded-lg text-center focus:ring-indigo-500 focus:border-indigo-500 py-1" 
                                                               onchange="this.form.submit()">
                                                    </form>
                                                </div>

                                                <!-- Eliminar -->
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="text-red-400 hover:text-red-600 transition flex items-center text-xs font-bold uppercase tracking-tighter">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Columna Derecha: Resumen de Pago -->
                        <div class="lg:w-1/3">
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-inner sticky top-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">Resumen del pedido</h3>
                                
                                <div class="space-y-4 border-b pb-6 text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Subtotal</span>
                                        <span class="font-medium text-gray-900">{{ number_format($total, 2) }}€</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Envío</span>
                                        <span class="text-green-600 font-bold">GRATIS</span>
                                    </div>
                                    <div class="flex justify-between text-xs italic">
                                        <span>IVA (4%)</span>
                                        <span>Incluido</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-6 mb-8">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <span class="text-3xl font-black text-indigo-700">{{ number_format($total, 2) }}€</span>
                                </div>

                                <form action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-all transform active:scale-95 flex items-center justify-center group">
                                        <span>Finalizar Pedido</span>
                                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </button>
                                </form>

                                <div class="mt-8 flex flex-col items-center">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-3">Métodos de pago aceptados</p>
                                    <div class="flex gap-3 grayscale opacity-40">
                                        <span class="text-[10px] font-black border border-gray-400 px-1 rounded">VISA</span>
                                        <span class="text-[10px] font-black border border-gray-400 px-1 rounded">MASTER</span>
                                        <span class="text-[10px] font-black border border-gray-400 px-1 rounded">PAYPAL</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Carrito Vacío -->
                    <div class="text-center py-20">
                        <div class="bg-indigo-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-2">Tu cesta está vacía</h3>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto text-lg">Aún no has añadido ninguna joya literaria a tu carrito.</p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-md">
                            Explorar la Tienda
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>