<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartMove') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

    {{-- Logo / App name --}}
    <div class="mb-6 text-center">
        <a href="/" class="text-2xl font-bold text-white">
            SmartMove
        </a>
        <p class="text-slate-400 text-sm mt-1">Your personal goal tracker</p>
    </div>

    {{-- Auth card --}}
    <div class="w-full sm:max-w-md px-6 py-6 card overflow-hidden">
        {{ $slot }}
    </div>

</body>

</html>