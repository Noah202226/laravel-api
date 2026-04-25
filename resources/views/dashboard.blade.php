<x-layout>

    <div class="mb-6">
        <h1 class="text-2xl font-bold">Welcome back 👋</h1>
        <p class="text-slate-400 text-sm mt-1">Here's where you stand today.</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="card text-center">
            <p class="text-3xl font-bold text-indigo-400">{{ $stats['total_goals'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Total Goals</p>
        </div>
        <div class="card text-center">
            <p class="text-3xl font-bold text-green-400">{{ $stats['completed_goals'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Completed</p>
        </div>
        <div class="card text-center">
            <p class="text-3xl font-bold text-yellow-400">{{ $stats['in_progress'] }}</p>
            <p class="text-xs text-slate-400 mt-1">In Progress</p>
        </div>
        <div class="card text-center">
            <p class="text-3xl font-bold text-white">{{ $stats['avg_progress'] }}%</p>
            <p class="text-xs text-slate-400 mt-1">Avg Progress</p>
        </div>
    </div>

    {{-- Recent Goals --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wide">Recent Goals</h2>
            <a href="{{ route('goals.goals') }}" class="text-xs text-indigo-400 hover:text-indigo-300">View all →</a>
        </div>

        @if ($recentGoals->isEmpty())
            <div class="card text-center py-10">
                <p class="text-slate-400 text-sm mb-3">No goals yet.</p>
                <a href="{{ route('goals.create') }}" class="btn btn-primary text-sm">+ Create your first goal</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($recentGoals as $goal)
                    <a href="{{ route('goals.goal', $goal->id) }}"
                        class="card flex items-center gap-4 hover:border-indigo-500 transition group block">
                        <span class="text-2xl">{{ $goal->cover_emoji ?? '🎯' }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate group-hover:text-indigo-400 transition">
                                {{ $goal->title }}
                            </p>
                            <div class="w-full bg-slate-700 rounded-full h-1 mt-1">
                                <div class="bg-indigo-500 h-1 rounded-full" style="width: {{ $goal->progress }}%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-semibold flex-shrink-0">{{ $goal->progress }}%</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Quick Actions --}}
    <div class="card">
        <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wide mb-3">Quick Actions</h2>
        <div class="flex gap-3">
            <a href="{{ route('goals.create') }}" class="btn btn-primary">+ New Goal</a>
            <a href="{{ route('goals.goals') }}" class="btn bg-slate-700 hover:bg-slate-600 text-white">View All
                Goals</a>
        </div>
    </div>

</x-layout>