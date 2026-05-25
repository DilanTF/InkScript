<x-app-layout>
    <!-- Estilos para ocultar las flechas feas del input number del navegador -->
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield; /* Para Firefox */
        }
    </style>

    <!-- Fondo crema corporativo de InkScript -->
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Botón Volver -->
            <div class="flex items-center">
                <a href="{{ route('shop.index') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#744E36] transition-colors bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100 hover:shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Catálogo
                </a>
            </div>

            <!-- Alertas de éxito (ACTUALIZADA CON BOTONES DE ACCIÓN) -->
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 shadow-sm rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Botón Seguir Comprando -->
                        <a href="{{ route('shop.index') }}" class="text-sm font-bold text-green-800 hover:text-green-900 hover:underline transition-colors whitespace-nowrap">
                            Seguir comprando
                        </a>
                        <!-- Botón Ir a la Cesta -->
                        <a href="{{ route('cart.index') }}" class="px-5 py-2 bg-green-600 text-white text-sm font-bold rounded-full hover:bg-green-700 transition-all shadow-sm flex items-center gap-2 whitespace-nowrap transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Ver mi cesta
                        </a>
                    </div>
                </div>
            @endif

            <!-- Tarjeta Principal del Libro -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 md:p-12 border border-gray-100">
                <div class="flex flex-col md:flex-row gap-12">
                    
                    <!-- Columna Izquierda: Portada -->
                    <div class="md:w-1/3 flex-shrink-0">
                        <div class="aspect-[2/3] bg-gray-100 rounded-2xl overflow-hidden shadow-lg border border-gray-200 relative group">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="object-cover w-full h-full transform group-hover:scale-105 transition duration-700">
                            @else
                                <!-- Portada Generada por Código -->
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#744E36] to-[#5c3d2a] text-white p-6 relative">
                                    <svg class="absolute right-0 bottom-0 text-white opacity-10 w-48 h-48 transform translate-x-12 translate-y-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    
                                    <span class="font-black text-center uppercase tracking-widest opacity-90 text-xl leading-tight z-10" style="font-family: 'Instrument Sans', sans-serif;">
                                        {{ $book->title }}
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Etiqueta de Formato Flotante -->
                            <div class="absolute top-4 left-4">
                                @if($book->is_digital)
                                    <span class="px-4 py-1.5 bg-white/90 backdrop-blur-sm text-xs font-black uppercase tracking-wider rounded-full shadow-md text-indigo-700 border border-white">E-book Digital</span>
                                @else
                                    <span class="px-4 py-1.5 bg-white/90 backdrop-blur-sm text-xs font-black uppercase tracking-wider rounded-full shadow-md border border-white" style="color: #744E36;">Libro Físico</span>
                                @endif
                            </div>
                        </div>

                        <!-- Metadatos extra -->
                        <div class="mt-8 space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <div class="flex justify-between items-center text-sm border-b border-gray-200 pb-3">
                                <span class="text-gray-500 font-medium">Publicación:</span>
                                <span class="font-bold text-gray-900">{{ $book->created_at->format('d M, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 font-medium">Categoría:</span>
                                <span class="font-bold text-gray-900">{{ $book->genre ?: 'General' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Información y Compra -->
                    <div class="md:w-2/3 flex flex-col">
                        
                        <!-- Encabezado y Estado -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-4 py-1.5 bg-amber-50 text-amber-700 text-xs font-black rounded-full uppercase tracking-wider border border-amber-100">
                                {{ $book->genre ?: 'Ficción' }}
                            </span>
                            
                            <!-- Estado de Stock Inteligente -->
                            @if($book->is_digital)
                                <span class="flex items-center text-indigo-600 text-sm font-bold bg-indigo-50 px-3 py-1 rounded-full" title="No requere envío físico">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Descarga Instantánea
                                </span>
                            @elseif($book->stock > 0)
                                <span class="flex items-center text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-full">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span> En Stock ({{ $book->stock }})
                                </span>
                            @else
                                <span class="flex items-center text-red-600 text-sm font-bold bg-red-50 px-3 py-1 rounded-full">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Agotado
                                </span>
                            @endif
                        </div>
                        
                        <!-- Título y Autor -->
                        <h1 class="text-4xl md:text-5xl font-black text-gray-900 mt-2 leading-tight" style="font-family: 'Instrument Sans', sans-serif;">
                            {{ $book->title }}
                        </h1>
                        
                        <p class="text-lg text-gray-500 mt-4 flex items-center gap-2">
                            Escrito por: 
                            <span class="font-bold text-gray-900">
                                {{ $book->user ? $book->user->name : 'Editorial InkScript' }}
                            </span>
                        </p>

                        <!-- Caja de Compra y Precio -->
                        <div class="mt-8 bg-[#FDFBF7] rounded-3xl p-8 border-2 border-[#744E36]/10 shadow-sm relative">
                            
                            <div class="flex items-baseline space-x-2 mb-6">
                                <span class="text-5xl font-black text-gray-900">{{ number_format($book->price, 2) }}€</span>
                                <span class="text-gray-500 font-medium">IVA incl.</span>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                
                                <div class="flex flex-col sm:flex-row items-stretch gap-4">
                                    
                                    <!-- Selector de Cantidad Mejorado -->
                                    <div class="flex items-center justify-between border-2 border-gray-200 rounded-full bg-white px-2 py-1 sm:w-40 transition-colors focus-within:border-[#744E36]" title="Máximo 10 unidades por pedido">
                                        <button type="button" onclick="decrement()" class="w-10 h-10 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-colors focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                        </button>
                                        
                                        <!-- Límite de seguridad: máximo 10 o el stock disponible -->
                                        <input type="number" name="quantity" id="quantity_input" value="1" min="1" max="{{ $book->is_digital ? 10 : min(10, $book->stock) }}" 
                                               class="w-14 border-none text-center font-black text-gray-900 text-lg focus:ring-0 p-0 bg-transparent" 
                                               onchange="validateQuantity(this)">
                                               
                                        <button type="button" onclick="increment()" class="w-10 h-10 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-colors focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>

                                    <!-- Botón Añadir -->
                                    <button type="submit" @if(!$book->is_digital && $book->stock <= 0) disabled @endif 
                                            class="flex-grow py-4 px-8 text-white font-black uppercase tracking-wider rounded-full shadow-lg transition-all transform active:scale-95 flex items-center justify-center gap-3 disabled:bg-gray-300 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none" 
                                            style="{{ (!$book->is_digital && $book->stock <= 0) ? '' : 'background-color: #744E36;' }}"
                                            @if($book->is_digital || $book->stock > 0)
                                                onmouseover="this.style.backgroundColor='#5c3d2a'" 
                                                onmouseout="this.style.backgroundColor='#744E36'"
                                            @endif>
                                        
                                        @if(!$book->is_digital && $book->stock <= 0)
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Sin Existencias
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            Añadir a la Cesta
                                        @endif
                                    </button>
                                </div>
                                
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-3 text-center sm:text-left">
                                    * Límite de seguridad: Máximo 10 unidades por transacción
                                </p>

                                <!-- NUEVO: Módulo de Regalo -->
                                <div class="mt-5 bg-white p-4 rounded-2xl border border-gray-200">
                                    <label class="flex items-center cursor-pointer select-none">
                                        <input type="checkbox" name="is_gift" id="is_gift" class="rounded border-gray-300 text-[#744E36] shadow-sm focus:ring-[#744E36] w-5 h-5 transition-colors" onchange="toggleGiftEmail()">
                                        <span class="ml-3 text-sm font-bold text-gray-800 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#744E36]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                            Comprar como regalo
                                        </span>
                                    </label>
                                    
                                    <div id="gift_email_container" class="hidden mt-3 pt-3 border-t border-gray-100 transition-all">
                                        <input type="email" name="recipient_email" placeholder="Correo del destinatario (opcional)" class="w-full text-sm border-gray-200 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] bg-gray-50 px-4 py-3 shadow-sm outline-none transition-colors">
                                        <p class="text-[10px] text-gray-500 mt-2 uppercase tracking-wider font-bold">Si es digital, le enviaremos un correo con un enlace de acceso seguro.</p>
                                    </div>
                                </div>

                            </form>
                            
                            <!-- Garantías de compra -->
                            <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-xs font-bold text-gray-400 uppercase tracking-widest">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Pago Seguro
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#744E36]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @if($book->is_digital)
                                        Envío al Correo
                                    @else
                                        Envío 24/48h
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Sinopsis Textual -->
                        <div class="mt-10 flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6" style="font-family: 'Instrument Sans', sans-serif;">
                                Acerca de esta obra
                            </h3>
                            <div class="text-gray-600 leading-loose text-lg font-serif">
                                {!! nl2br(e($book->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Script de lógicas interactivas -->
    <script>
        // Función para validar escritura manual
        function validateQuantity(input) {
            let val = parseInt(input.value);
            const max = parseInt(input.getAttribute('max'));
            
            // Si pone letras o negativo, vuelve a 1
            if (isNaN(val) || val < 1) {
                input.value = 1;
            } 
            // Si pone más del stock, se baja al máximo
            else if (!isNaN(max) && val > max) {
                input.value = max;
            }
        }

        // Función para sumar con el botón '+'
        function increment() {
            const input = document.getElementById('quantity_input');
            const max = parseInt(input.getAttribute('max'));
            let val = parseInt(input.value) || 1;
            
            if (val < max || isNaN(max)) {
                input.value = val + 1;
            }
        }

        // Función para restar con el botón '-'
        function decrement() {
            const input = document.getElementById('quantity_input');
            let val = parseInt(input.value) || 1;
            
            if (val > 1) {
                input.value = val - 1;
            } else {
                input.value = 1;
            }
        }

        // Función para mostrar la caja de regalo
        function toggleGiftEmail() {
            const container = document.getElementById('gift_email_container');
            const checkbox = document.getElementById('is_gift');
            if (checkbox.checked) {
                container.classList.remove('hidden');
                container.classList.add('block');
            } else {
                container.classList.add('hidden');
                container.classList.remove('block');
            }
        }
    </script>
</x-app-layout>