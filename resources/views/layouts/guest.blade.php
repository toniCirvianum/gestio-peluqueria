<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/favicon.ico') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-purple-600 to-blue-400 min-h-screen flex flex-col justify-center items-center">
<!-- Logo i Títol -->
<div class="animate-fade-in-down">
    <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-white" />
    </a>
    <h1 class="text-4xl font-bold text-white mt-4">Benvingut a IC-Pelu</h1>
</div>

<!-- Contenidor principal -->
<div class="w-full sm:max-w-lg mt-8 px-8 py-6 bg-white dark:bg-gray-800 shadow-2xl rounded-lg animate-fade-in-up">
    {{ $slot }}
</div>

<!-- Footer -->
<footer class="text-white text-sm mt-8 animate-fade-in">
    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tots els drets reservats.</p>
</footer>

<!-- Animacions -->
<style>
    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.8s ease-out;
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out;
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
</style>
</body>
</html>
