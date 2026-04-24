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
    <aside class="w-64 bg-slate-900 border-r border-slate-800 p-6 hidden md:block">
        <h1 class="text-xl font-bold mb-8 text-white">SmartMove</h1>

        <nav class="space-y-3">
            <a href="/" class="block nav-link">Dashboard</a>
            <a href="{{ route('goals.goals') }}" class="block nav-link">Goals</a>
            <a href="{{ route('goals.create') }}" class="block nav-link">Create Goal</a>
            <a href="/decisions" class="block nav-link">Decisions</a>
            <a href="/tasks" class="block nav-link">Tasks</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Topbar -->
        <header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold">Dashboard</h2>

            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-400">Welcome back 👋</span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            <div class="container">

                {{-- Add this inside <main> in your layout.blade.php, just before {{ $slot }} --}}

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