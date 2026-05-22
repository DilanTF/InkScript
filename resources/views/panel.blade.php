<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Contenedor Flex para separar Menú Lateral y Contenido -->
            <div class="flex flex-col md:flex-row gap-8">

                <!-- 1. SIDEBAR (Menú Lateral Marrón) -->
                <div class="w-full md:w-64 flex-shrink-0">
                    <!-- Usamos sticky para que el menú te siga si haces scroll -->
                    <div class="bg-[#744E36] rounded-2xl shadow-xl overflow-hidden sticky top-24">
                        <nav class="flex flex-col py-6">
                            <!-- Enlaces del menú -->
                            <a href="{{ route('profile.edit') }}" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                Perfil
                            </a>
                            <a href="#" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                Mis Lecturas
                            </a>
                            <a href="{{ route('orders.index') }}" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                Mis Compras
                            </a>
                            
                            <!-- Opciones exclusivas para Autores -->
                            @if(auth()->user()->role === 'author')
                                <a href="{{ route('stories.index') }}" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                    Mis Publicaciones
                                </a>
                                <a href="#" class="px-8 py-4 text-white text-lg font-semibold hover:bg-[#5c3d2a] transition border-l-4 border-transparent hover:border-white">
                                    Resumen de Ventas
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>

                <!-- 2. CONTENIDO PRINCIPAL -->
                <div class="flex-grow bg-white rounded-2xl shadow-sm p-8 border border-gray-200">
                    
                    <!-- Cabecera del panel -->
                    <div class="mb-10 pb-4 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-3xl font-black text-gray-800">Hola, "{{ Auth::user()->name }}"</h2>
                        
                        <!-- Botón de Cerrar Sesión replicado del mockup -->
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="px-6 py-2 bg-[#744E36] text-white font-semibold rounded-full hover:bg-[#5c3d2a] transition shadow-md">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>

                    <!-- Avisos / Notificaciones -->
                    <div class="space-y-4 mb-12">
                        <!-- Notificación de Lector -->
                        <div class="bg-gray-50 px-6 py-4 rounded-xl border border-gray-200 flex items-center justify-center text-center">
                            <span class="text-lg font-medium text-gray-700">Lectores: "Tienes 3 capítulos pendientes de leer"</span>
                        </div>

                        <!-- Notificación de Autor -->
                        @if(auth()->user()->role === 'author')
                        <div class="bg-gray-50 px-6 py-4 rounded-xl border border-gray-200 flex items-center justify-center text-center">
                            <span class="text-lg font-medium text-gray-700">Autores: "Tus historias han recibido 5 nuevos comentarios hoy"</span>
                        </div>
                        @endif
                    </div>

                    <!-- Cuadricula de Acciones Principales -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-8">
                        
                        <!-- Acción 1: Leer Ahora -->
                        <div class="flex flex-col items-center group cursor-pointer">
                            <div class="w-40 h-40 bg-black rounded-3xl flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 shadow-xl">
                                <!-- Icono SVG de Montañas (Placeholder de Imagen) -->
                                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                            </div>
                            <span class="font-extrabold text-xl text-gray-900 text-center leading-tight">Leer<br>ahora</span>
                        </div>

                        <!-- Acción 2: Descargar PDF -->
                        <div class="flex flex-col items-center group cursor-pointer">
                            <div class="w-40 h-40 bg-black rounded-3xl flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 shadow-xl">
                                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                            </div>
                            <!-- Estilo de borde morado/azul replicando el mockup -->
                            <span class="font-extrabold text-xl text-center leading-tight px-4 py-2 border-2 border-indigo-600 text-indigo-700 rounded-lg">Descargar<br>PDF</span>
                        </div>

                        <!-- Acción 3: Añadir Capítulo (Solo Autores) -->
                        @if(auth()->user()->role === 'author')
                        <div class="flex flex-col items-center group cursor-pointer">
                            <div class="w-40 h-40 bg-black rounded-3xl flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 shadow-xl">
                                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                            </div>
                            <span class="font-extrabold text-xl text-gray-900 text-center leading-tight">Añadir<br>Capítulo</span>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>