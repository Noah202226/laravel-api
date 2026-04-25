<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartMove</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 border-r border-slate-800 p-6 hidden md:flex flex-col">

        {{-- Logo --}}
        <h1 class="text-xl font-bold mb-8 text-white">SmartMove</h1>

        {{-- Nav Links --}}
        <nav class="space-y-1 flex-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg nav-link
                      {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('goals.goals') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg nav-link
                      {{ request()->routeIs('goals.*') ? 'bg-indigo-600 text-white' : '' }}">
                🎯 Goals
            </a>
            <a href="{{ route('goals.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg nav-link">
                ✨ Upcoming Features
            </a>
            {{-- Future links --}}
            {{-- <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg nav-link">🧠 Decisions</a> --}}
            {{-- <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg nav-link">✅ Tasks</a> --}}
        </nav>

        {{-- Bottom: Profile + Logout --}}
        <div class="border-t border-slate-800 pt-4 mt-4 space-y-2">

            {{-- Profile --}}
            @auth
                <div class="px-3 py-2 rounded-lg bg-slate-800 mb-2">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg nav-link text-sm">
                    👤 Profile & Settings
                </a>
            @endauth

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                               text-red-400 hover:text-red-300 hover:bg-red-500/10 transition text-left">
                    🚪 Logout
                </button>
            </form>

        </div>

    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Topbar -->
        <header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold">{{ config('app.name', 'SmartMove') }}</h2>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-slate-400">{{ auth()->user()->name }} 👋</span>
                @endauth
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-auto">
            <div class="container">

                @if (session('success'))
                    <div
                        class="mb-4 px-4 py-3 rounded-lg bg-green-500/20 text-green-400 text-sm border border-green-500/30">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-lg bg-red-500/20 text-red-400 text-sm border border-red-500/30">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}

            </div>
        </main>

    </div>

</body>

</html>