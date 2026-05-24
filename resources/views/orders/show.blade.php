<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Botón Volver -->
            <div class="flex items-center mb-6">
                <a href="{{ route('orders.index') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#744E36] transition-colors bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100 hover:shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a Mis Pedidos
                </a>
            </div>

            <!-- Alertas -->
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 shadow-sm rounded-2xl flex items-center mb-8">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Columna Izquierda: Artículos Comprados -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        
                        <!-- Encabezado Factura -->
                        <div class="p-8 border-b border-gray-100 bg-[#FDFBF7] flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Detalles de la Transacción</p>
                                <h2 class="text-3xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                                    Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </h2>
                            </div>
                            <div class="text-left md:text-right">
                                <span class="px-4 py-1.5 bg-green-50 text-green-700 text-sm font-bold rounded-full uppercase tracking-wider border border-green-100">
                                    {{ $order->status }}
                                </span>
                                <p class="text-sm text-gray-500 mt-2 font-medium">
                                    {{ $order->created_at->format('d/m/Y - H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Lista de Libros -->
                        <div class="p-8 space-y-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Artículos Adquiridos</h3>
                            
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-6 p-4 rounded-2xl border border-gray-100 hover:border-[#744E36]/30 hover:bg-[#F9F7F2]/50 transition-all">
                                    
                                    <div class="w-16 h-24 bg-gray-100 rounded-lg overflow-hidden shadow-sm flex-shrink-0 border border-gray-200">
                                        @if($item->book->image)
                                            <img src="{{ asset('storage/' . $item->book->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-[#744E36] to-[#5c3d2a] text-white flex items-center justify-center p-1">
                                                <span class="text-[6px] font-black uppercase text-center leading-tight">{{ $item->book->title }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-grow">
                                        <h4 class="font-bold text-lg text-gray-900 leading-tight">{{ $item->book->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider font-bold">
                                            {{ $item->book->is_digital ? 'Digital (E-book)' : 'Físico (Tapa Blanda)' }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-2">Cantidad: {{ $item->quantity }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <span class="font-black text-gray-900 text-xl">{{ number_format($item->price * $item->quantity, 2) }}€</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Datos de Envío y Resumen -->
                <div class="lg:w-1/3 space-y-8">
                    
                    <!-- Tarjeta de Envío / Regalo -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4" style="font-family: 'Instrument Sans', sans-serif;">Información</h3>
                        
                        @if($order->is_gift)
                            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                                <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                <div>
                                    <p class="text-sm font-bold text-amber-800">Pedido para Regalo</p>
                                    <p class="text-xs text-amber-700 mt-1">Destinatario: <br><span class="font-medium">{{ $order->gift_email ?? 'No especificado' }}</span></p>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Dirección de Facturación/Envío</p>
                                @if($order->shipping_address)
                                    <p class="text-sm font-medium text-gray-800 mt-1 leading-relaxed">
                                        {{ $order->shipping_address }}<br>
                                        {{ $order->shipping_postal_code }} - {{ $order->shipping_city }}<br>
                                        {{ $order->shipping_country }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500 mt-1 italic">Producto 100% digital. No requiere envío físico.</p>
                                @endif
                            </div>
                            
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-4">Comprador</p>
                                <p class="text-sm font-medium text-gray-800 mt-1">{{ $order->user->name }} ({{ $order->user->email }})</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Resumen -->
                    <div class="bg-gradient-to-br from-[#744E36] to-[#5c3d2a] rounded-3xl p-8 shadow-lg text-white">
                        <h3 class="text-xl font-bold mb-6 border-b border-white/20 pb-4" style="font-family: 'Instrument Sans', sans-serif;">Resumen Económico</h3>
                        
                        <div class="space-y-3 text-sm text-white/80">
                            <div class="flex justify-between items-center">
                                <span>Subtotal</span>
                                <span>{{ number_format($order->total_amount, 2) }}€</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Gastos de Envío</span>
                                <span>0.00€</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Impuestos</span>
                                <span>Incluidos</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end mt-6 pt-6 border-t border-white/20">
                            <span class="text-lg font-bold">Total Pagado</span>
                            <span class="text-4xl font-black">{{ number_format($order->total_amount, 2) }}€</span>
                        </div>
                        
                        <div class="mt-8 text-center text-xs text-white/60 font-medium">
                            <i class="fa-solid fa-lock mr-1"></i> Transacción procesada y asegurada por InkScript.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>