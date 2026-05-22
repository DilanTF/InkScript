<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="mb-10 text-center">
                <h2 class="text-4xl font-black text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Ajustes de Cuenta
                </h2>
                <p class="text-gray-500 mt-2 text-lg">Gestiona tu información personal y la seguridad de tu perfil.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 transition-shadow hover:shadow-md">
                <div class="p-8 sm:p-12">
                    <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
                        <div class="w-12 h-12 bg-[#744E36] rounded-full flex items-center justify-center text-white text-xl shadow-sm">
                            👤
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800" style="color: #744E36;">Información del Perfil</h3>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 transition-shadow hover:shadow-md">
                <div class="p-8 sm:p-12">
                    <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
                        <div class="w-12 h-12 bg-[#744E36] rounded-full flex items-center justify-center text-white text-xl shadow-sm">
                            🔒
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800" style="color: #744E36;">Actualizar Contraseña</h3>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-red-50 overflow-hidden shadow-sm rounded-3xl border border-red-100 transition-shadow hover:shadow-md">
                <div class="p-8 sm:p-12">
                    <div class="flex items-center gap-4 mb-6 border-b border-red-200 pb-4">
                        <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white text-xl shadow-sm">
                            ⚠️
                        </div>
                        <h3 class="text-2xl font-bold text-red-800">Zona de Peligro</h3>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>