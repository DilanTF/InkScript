<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $story->title }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('stories.index') }}" class="text-sm text-gray-600 hover:underline">Volver al listado</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-2">Sinopsis</h3>
                <p class="text-gray-700 italic">{{ $story->description }}</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Capítulos de la Obra</h3>
                    <a href="{{ route('stories.chapters.create', $story) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                        + Añadir Capítulo
                    </a>
                </div>

                @if($story->chapters->isEmpty())
                    <p class="text-gray-500 text-center py-4">Aún no has escrito capítulos para esta historia.</p>
                @else
                    <div class="space-y-4">
                        @foreach($story->chapters as $chapter)
                            <div class="flex justify-between items-center border-b pb-4">
                                <div>
                                    <span class="text-sm font-bold text-indigo-600">Capítulo {{ $chapter->order_number }}</span>
                                    <h4 class="text-md font-semibold">{{ $chapter->title }}</h4>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="#" class="text-blue-500 hover:underline text-sm">Leer</a>
                                    <a href="#" class="text-gray-500 hover:underline text-sm">Editar</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if(Auth::id() == $story->user_id)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800">💰 Publicar esta historia en la Tienda</h3>
                    <p class="text-sm text-gray-600">Convierte tu historia en un libro a la venta para los lectores.</p>
                </div>

                <form action="{{ route('stories.sell', $story->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Precio (€)</label>
                            <input type="number" name="price" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="9.99" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Stock Inicial</label>
                            <input type="number" name="stock" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="100" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Formato</label>
                            <select name="is_digital" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="0">Físico</option>
                                <option value="1">Digital</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Género</label>
                            <input type="text" name="genre" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Ej: Épica" required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-8 rounded-lg transition duration-150 ease-in-out">
                            Poner a la venta ahora
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>