<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📈 Panel de Ventas del Autor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Ingresos Totales</p>
                    <p class="text-3xl font-black text-gray-900">{{ number_format($totalEarnings, 2) }}€</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Ejemplares Vendidos</p>
                    <p class="text-3xl font-black text-gray-900">{{ $totalSold }} uds.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Libros en Tienda</p>
                    <p class="text-3xl font-black text-gray-900">{{ $myBooks->count() }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Desglose de Ventas Recientes</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b text-gray-400 text-sm uppercase">
                            <th class="py-3">Libro</th>
                            <th class="py-3">Fecha</th>
                            <th class="py-3">Cantidad</th>
                            <th class="py-3 text-right">Ganancia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4 font-bold">{{ $sale->book->title }}</td>
                            <td class="py-4 text-sm text-gray-600">{{ $sale->created_at->format('d/m/Y') }}</td>
                            <td class="py-4">{{ $sale->quantity }}</td>
                            <td class="py-4 text-right font-bold text-green-600">
                                {{ number_format($sale->price * $sale->quantity, 2) }}€
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>