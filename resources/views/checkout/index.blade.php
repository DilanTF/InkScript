<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Encabezado -->
            <div class="mb-10 text-center md:text-left">
                <a href="{{ route('cart.index') }}" class="text-sm font-bold hover:underline mb-3 inline-flex items-center" style="color: #744E36;">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Carrito
                </a>
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Finalizar Compra
                </h2>
                <p class="text-gray-500 mt-2 text-lg">Completa tus datos para procesar el pedido de forma segura.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Columna Izquierda: Formulario de Pago -->
                <div class="lg:w-2/3 space-y-8">
                    
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        
                        <!-- 1. Datos de Contacto -->
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                                <span class="w-8 h-8 rounded-full bg-[#744E36] text-white flex items-center justify-center text-sm">1</span>
                                Datos de Contacto
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Nombre Completo</label>
                                    <input type="text" value="{{ Auth::user()->name }}" class="w-full border-gray-200 rounded-xl bg-gray-50 px-4 py-3 cursor-not-allowed" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Correo Electrónico</label>
                                    <input type="email" value="{{ Auth::user()->email }}" class="w-full border-gray-200 rounded-xl bg-gray-50 px-4 py-3 cursor-not-allowed" readonly>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-3 font-medium"><i class="fa-solid fa-lock mr-1"></i> Vinculado a tu cuenta de InkScript de forma segura.</p>
                        </div>

                        <!-- 2. Dirección de Envío/Facturación -->
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                                <span class="w-8 h-8 rounded-full bg-[#744E36] text-white flex items-center justify-center text-sm">2</span>
                                Dirección de Facturación
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Dirección (Calle, Número, Piso)</label>
                                    <input type="text" placeholder="Ej: Calle Gran Vía, 12, 3ºA" class="w-full border-gray-300 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3" required>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Ciudad</label>
                                        <input type="text" placeholder="Madrid" class="w-full border-gray-300 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">C. Postal</label>
                                        <input type="text" placeholder="28013" class="w-full border-gray-300 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3" required>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">País</label>
                                    <select class="w-full border-gray-300 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3 bg-white" required>
                                        <option value="ES">España</option>
                                        <option value="MX">México</option>
                                        <option value="AR">Argentina</option>
                                        <option value="CO">Colombia</option>
                                        <option value="CL">Chile</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Método de Pago (Simulado) -->
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                                <span class="w-8 h-8 rounded-full bg-[#744E36] text-white flex items-center justify-center text-sm">3</span>
                                Método de Pago
                            </h3>
                            
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 relative overflow-hidden">
                                <!-- Simulador de Tarjeta -->
                                <div class="mb-4 flex justify-between items-center">
                                    <span class="font-bold text-gray-700 uppercase tracking-wider text-sm">Tarjeta de Crédito / Débito</span>
                                    <div class="flex gap-2 text-gray-400">
                                        <i class="fa-brands fa-cc-visa text-2xl"></i>
                                        <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Número de Tarjeta</label>
                                        <div class="relative">
                                            <input type="text" placeholder="0000 0000 0000 0000" class="w-full border-gray-300 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3 pl-10 font-mono tracking-widest" required maxlength="19">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                                <i class="fa-regular fa-credit-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Caducidad</label>
                                            <input type="text" placeholder="MM/YY" class="w-full border-gray-300 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3 font-mono" required maxlength="5">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">CVC</label>
                                            <div class="relative">
                                                <input type="text" placeholder="123" class="w-full border-gray-300 rounded-xl focus:ring-[#744E36] focus:border-[#744E36] px-4 py-3 font-mono" required maxlength="4">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                                    <i class="fa-solid fa-circle-question" title="Código de 3 dígitos en el reverso"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 bg-green-50 p-3 rounded-lg border border-green-100 text-xs text-green-700 text-center font-medium flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Entorno TFG Simulado - No se realizarán cargos reales a la tarjeta.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Columna Derecha: Resumen de Compra -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4" style="font-family: 'Instrument Sans', sans-serif;">Resumen de Compra</h3>
                        
                        <!-- Lista de Items miniatura -->
                        <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2">
                            @foreach($cart as $details)
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-16 bg-gray-100 rounded flex-shrink-0 overflow-hidden border border-gray-200">
                                        @if($details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-[#744E36] to-[#5c3d2a] opacity-90"></div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ $details['title'] }}</p>
                                        <p class="text-xs text-gray-500">Cant: {{ $details['quantity'] }}</p>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($details['price'] * $details['quantity'], 2) }}€</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-3 border-t border-gray-100 pt-4 text-gray-600 text-sm">
                            <div class="flex justify-between items-center">
                                <span>Subtotal</span>
                                <span class="font-medium text-gray-900">{{ number_format($total, 2) }}€</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Envío</span>
                                <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded text-xs uppercase tracking-wider">Gratis</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end mt-6 mb-8 pt-4 border-t border-gray-100">
                            <span class="text-lg font-bold text-gray-900">Total a Pagar</span>
                            <span class="text-3xl font-black text-[#744E36]">{{ number_format($total, 2) }}€</span>
                        </div>

                        <button type="submit" form="checkout-form" class="w-full text-white font-bold py-4 px-6 rounded-full shadow-lg transition-all transform active:scale-95 flex items-center justify-center group text-lg" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                            <span>Pagar {{ number_format($total, 2) }}€</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                        
                        <p class="text-center text-[10px] text-gray-400 mt-4 uppercase tracking-widest font-bold">
                            Al procesar el pago aceptas nuestros Términos y Condiciones de venta de InkScript.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>