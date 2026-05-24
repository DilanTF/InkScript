<nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-[100]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <div class="shrink-0 flex items-center mr-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 transition hover:opacity-80" style="text-decoration: none;">
                        <img src="{{ asset('images/InkScript.png') }}" alt="InkScript Logo" 
                             class="block object-contain" 
                             style="height: 65px; width: auto; max-width: 100%;" />
                        <span class="font-black text-xl tracking-tight hidden sm:block" style="color: #744E36; font-weight: 900;">InkScript</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:flex h-full">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out hover:text-[#744E36] {{ request()->routeIs('dashboard') ? 'border-[#744E36] text-[#744E36]' : 'border-transparent text-gray-500' }}"
                       style="text-decoration: none;">
                        {{ __('Inicio') }}
                    </a>

                    @if(auth()->user() && auth()->user()->role === 'author')
                        <a href="{{ route('stories.index') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out hover:text-[#744E36] {{ request()->routeIs('stories.*') ? 'border-[#744E36] text-[#744E36]' : 'border-transparent text-gray-500' }}"
                           style="text-decoration: none;">
                            {{ __('Mis Historias') }}
                        </a>
                    @endif

                    <a href="{{ route('shop.index') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out hover:text-[#744E36] {{ request()->routeIs('shop.*') ? 'border-[#744E36] text-[#744E36]' : 'border-transparent text-gray-500' }}"
                       style="text-decoration: none;">
                        {{ __('Tienda') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4 relative z-50">
                
                <div class="relative z-10">
                    <form action="{{ route('shop.index') }}" method="GET" class="relative hidden sm:block">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Buscar libros, géneros..." 
                            class="pl-10 pr-4 py-2 border-gray-200 rounded-full focus:ring-[#744E36] focus:border-[#744E36] text-sm w-64 bg-gray-50 transition-colors">
                    </form>
                </div>

                <div class="relative z-50">
                    <button type="button" 
                            onclick="toggleUserDropdown(event)"
                            class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-full text-white transition ease-in-out duration-150 focus:outline-none shadow-sm cursor-pointer relative z-50 hover:bg-[#5c3d2a]" 
                            style="background-color: #744E36; border: none;">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-2">
                            <svg id="dropdown-arrow" class="fill-current h-4 w-4 text-white transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div id="user-dropdown-menu" 
                         class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl py-2 border border-gray-200 transition-opacity duration-200" 
                         style="z-index: 9999;">
                        
                        <div class="px-4 py-2 text-xs text-gray-400 font-bold uppercase tracking-wider border-b border-gray-50 mb-1">
                            Tu Cuenta
                        </div>

                        <a href="{{ route('panel') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#744E36] transition-colors" style="font-weight: 500;">
                            🎛️ Mi Panel
                        </a>

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#744E36] transition-colors" style="font-weight: 500;">
                            👤 Mi Perfil
                        </a>
                        
                        <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#744E36] transition-colors" style="font-weight: 500;">
                            🛒 Mi Carrito
                        </a>

                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#744E36] transition-colors" style="font-weight: 500;">
                            📦 Mis Pedidos
                        </a>

                        @if(auth()->user() && auth()->user()->role === 'author')
                            <a href="{{ route('stories.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#744E36] transition-colors" style="font-weight: 500;">
                                📚 Mis Historias
                            </a>
                        @endif

                        <div class="border-t border-gray-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors" style="font-weight: 600;">
                                🚪 Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button onclick="toggleMobileMenu(event)" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden sm:hidden border-t border-gray-200 bg-white shadow-lg relative z-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-medium">
                {{ __('Inicio') }}
            </x-responsive-nav-link>

            @if(auth()->user() && auth()->user()->role === 'author')
                <x-responsive-nav-link :href="route('stories.index')" :active="request()->routeIs('stories.*')" class="font-medium">
                    {{ __('Mis Historias') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')" class="font-medium">
                {{ __('Tienda') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4 mb-3">
                <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('panel')" class="font-medium text-gray-700">
                    🎛️ Mi Panel
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" class="font-medium text-gray-700">
                    👤 Mi Perfil
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart.index')" class="font-medium text-gray-700">
                    🛒 Mi Carrito
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')" class="font-medium text-gray-700">
                    📦 Mis Pedidos
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-medium text-red-600">
                        🚪 Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const menu = document.getElementById('user-dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        } else {
            menu.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }

    function toggleMobileMenu(event) {
        event.stopPropagation();
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('user-dropdown-menu');
        const userArrow = document.getElementById('dropdown-arrow');
        
        if (userMenu && !userMenu.classList.contains('hidden')) {
            userMenu.classList.add('hidden');
            if (userArrow) userArrow.classList.remove('rotate-180');
        }
    });

    document.getElementById('user-dropdown-menu')?.addEventListener('click', function(event) {
        event.stopPropagation();
    });
</script>