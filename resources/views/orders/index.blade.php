<x-app-layout>
    <!-- Fondo crema corporativo -->
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Botón Volver a Mi Panel -->
            <div class="flex items-center mb-2">
                <a href="{{ route('panel') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#744E36] transition-colors bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100 hover:shadow w-max">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a Mi Panel
                </a>
            </div>

            <!-- Encabezado elegante -->
            <div class="mb-10 text-center">
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Mis Pedidos Realizados
                </h2>
                <p class="text-gray-500 mt-2 text-lg">El historial de tus adquisiciones y tesoros literarios.</p>
            </div>

            @if($orders->count() > 0)
                <div class="space-y-8">
                    @foreach ($orders as $order)
                        <!-- Tarjeta de Pedido Premium -->
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 hover:shadow-md transition-shadow">
                            
                            <!-- Cabecera del pedido (Info y Total) -->
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 border-b border-gray-50 pb-6">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <!-- Formateamos el ID para que parezca un número de factura real (Ej: #00042) -->
                                        <h3 class="text-xl font-bold text-gray-900">Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                        
                                        <!-- Etiqueta de estado -->
                                        <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider border border-green-100">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 flex items-center gap-1 font-medium">
                                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Realizado el {{ $order->created_at->format('d de M, Y - H:i') }}
                                    </p>
                                </div>
                                <div class="text-left md:text-right mt-2 md:mt-0 bg-gray-50 md:bg-transparent p-4 md:p-0 rounded-xl md:rounded-none w-full md:w-auto">
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Total Pagado</p>
                                    <p class="text-3xl font-black text-gray-900">{{ number_format($order->total_amount, 2) }}€</p>
                                </div>
                            </div>

                            <!-- Cuerpo del pedido (Miniaturas y Botón) -->
                            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                                
                                <!-- Miniaturas de libros apiladas -->
                                <div class="flex items-center gap-4 w-full md:w-auto">
                                    <div class="flex -space-x-4">
                                        @foreach($order->items->take(4) as $item)
                                            <div class="w-14 h-20 bg-gray-100 border-2 border-white rounded-lg shadow-sm overflow-hidden flex-shrink-0 relative" style="z-index: {{ 40 - ($loop->index * 10) }};" title="{{ $item->book->title }}">
                                                @if($item->book->image)
                                                    <img src="{{ asset('storage/' . $item->book->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <!-- Diseño para cuando no hay imagen -->
                                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#744E36] to-[#5c3d2a] text-white">
                                                        <span class="text-[7px] font-black uppercase text-center px-1 leading-tight">{{ mb_strimwidth($item->book->title, 0, 15, '...') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        
                                        <!-- Círculo que indica si hay más de 4 libros -->
                                        @if($order->items->count() > 4)
                                            <div class="w-14 h-20 bg-gray-50 border-2 border-white rounded-lg shadow-sm flex items-center justify-center text-sm font-bold text-gray-500 relative z-0">
                                                +{{ $order->items->count() - 4 }}
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 font-medium">{{ $order->items->count() }} artículo(s)</p>
                                </div>

                                <!-- Botón Ver Detalles (Estilo outline corporativo) -->
                                <div class="w-full md:w-auto text-right">
                                    <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center justify-center px-6 py-3 border-2 text-sm font-bold rounded-full transition-colors w-full md:w-auto" style="border-color: #744E36; color: #744E36;" onmouseover="this.style.backgroundColor='#744E36'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#744E36';">
                                        Ver detalles del pedido
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado Vacío Premium (Empty State) -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center max-w-2xl mx-auto my-10">
                    <div class="w-32 h-32 mx-auto mb-8 relative">
                        <div class="absolute inset-0 bg-[#F9F7F2] rounded-full flex items-center justify-center">
                            <!-- Icono de un documento/factura -->
                            <svg class="w-16 h-16" style="color: #744E36;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Aún no has realizado ninguna compra</h3>
                    <p class="text-gray-500 mb-10 text-lg leading-relaxed">Tu historial de pedidos está en blanco por ahora. Date una vuelta por nuestra tienda y encuentra tu próxima gran lectura.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center px-10 py-4 text-white font-bold rounded-full shadow-md transition-all transform hover:-translate-y-1 hover:shadow-lg text-lg" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                        Ir a la Tienda
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>