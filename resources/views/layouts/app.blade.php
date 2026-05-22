<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- 1. TÍTULO DE LA PESTAÑA DEL NAVEGADOR -->
        <title>InkScript</title>

        <!-- 2. ICONO DE LA PESTAÑA (FAVICON) -->
        <link rel="icon" href="{{ asset('images/InkScript.png') }}" type="image/png">

        <!-- Fonts (Añadida la tipografía elegante que usaste en Login) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900" rel="stylesheet" />

        <!-- Scripts de Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
        <div class="min-h-screen bg-gray-50">
            <!-- Aquí es donde se inyecta tu navigation.blade.php -->
            @include('layouts.navigation')

            <!-- Cabecera opcional de la página (Ej: "Mis Historias") -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Contenido Principal de cada vista -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>