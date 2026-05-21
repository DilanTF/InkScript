<x-app-layout>
    <!-- Eliminamos el x-slot name="header" para que no salga la franja gris -->

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Contenedor principal con estilo limpio -->
            <div class="flex flex-col gap-8">
                
                <!-- Sección de Bienvenida -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h1 class="text-3xl font-extrabold text-gray-900">¡Hola, {{ Auth::user()->name }}! 👋</h1>
                    <p class="mt-3 text-lg text-gray-500">Es un placer tenerte aquí de vuelta en InkScript.</p>
                </div>

                <!-- Grid de Acciones -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Tarjeta: Tienda -->
                    <div class="bg-indigo-900 p-8 rounded-2xl shadow-lg text-white">
                        <h3 class="text-xl font-bold">Explorar historias</h3>
                        <p class="mt-2 text-indigo-100">Sumérgete en miles de mundos creados por nuestra comunidad.</p>
                        <div class="mt-6">
                            <a href="{{ route('shop.index') }}" class="inline-block bg-white text-indigo-900 font-semibold px-6 py-2 rounded-full hover:bg-gray-100 transition">
                                Ir a la tienda
                            </a>
                        </div>
                    </div>

                    <!-- Tarjeta: Gestión (Solo si es autor) -->
                    @if(auth()->user()->role === 'author')
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900">Tu Escritorio</h3>
                        <p class="mt-2 text-gray-500">Tienes nuevas notificaciones en tus historias publicadas.</p>
                        <div class="mt-6">
                            <a href="{{ route('stories.index') }}" class="inline-block bg-gray-900 text-white font-semibold px-6 py-2 rounded-full hover:bg-gray-700 transition">
                                Gestionar obras
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>