<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Mis Pedidos Realizados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($orders as $order)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border border-gray-100">
                    <div class="flex flex-wrap justify-between items-center border-b pb-4 mb-4">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pedido #{{ $order->id }}</span>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-green-100 text-green-700">
                                {{ $order->status }}
                            </span>
                            <p class="text-xl font-black text-indigo-700 mt-1">{{ number_format($order->total_amount, 2) }}€</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-14 bg-gray-200 rounded mr-4 overflow-hidden">
                                        @if($item->book && $item->book->image)
                                            <img src="{{ asset('storage/' . $item->book->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $item->book->title ?? 'Libro no disponible' }}</p>
                                        <p class="text-xs text-gray-500">Cantidad: {{ $item->quantity }} x {{ number_format($item->price, 2) }}€</p>
                                    </div>
                                </div>
                                @if($item->book && $item->book->is_digital)
                                    <a href="#" class="text-xs font-bold text-indigo-600 hover:underline">📥 Descargar E-book</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-lg shadow-sm">
                    <p class="text-gray-500 italic">Aún no has realizado ninguna compra.</p>
                    <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-indigo-600 font-bold">Ir a la tienda &rarr;</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>