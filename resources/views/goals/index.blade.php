<x-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="title">Your Goals</h1>
        <a href="{{ route('goals.create') }}" class="btn btn-primary">+ New Goal</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($goals as $goal)
            <x-card href="{{ route('goals.goal', ['id' => $goal->id]) }}">

                {{-- Emoji + Title --}}
                <div class="flex items-center gap-2 mb-1">
                    @if ($goal->cover_emoji)
                        <span class="text-2xl">{{ $goal->cover_emoji }}</span>
                    @endif
                    <h2 class="text-lg font-semibold leading-snug">
                        {{ $goal->title }}
                    </h2>
                </div>

                {{-- Category --}}
                @if ($goal->category)
                    <span class="text-xs text-indigo-400 font-medium">{{ $goal->category }}</span>
                @endif

                {{-- Description --}}
                <p class="text-sm text-slate-400 mt-1 line-clamp-2">
                    {{ $goal->description ?? 'No description.' }}
                </p>

                {{-- Progress bar --}}
                <div class="mt-3">
                    <div class="flex justify-between text-xs text-slate-500 mb-1">
                        <span>Progress</span>
                        <span>{{ $goal->progress }}%</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-1.5">
                        <div class="bg-indigo-500 h-1.5 rounded-full transition-all" style="width: {{ $goal->progress }}%">
                        </div>
                    </div>
                </div>

                {{-- Status + Priority --}}
                <div class="flex gap-2 mt-3">
                    <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $goal->status === 'completed' ? 'bg-green-500/20 text-green-400'
            : ($goal->status === 'in_progress' ? 'bg-indigo-500/20 text-indigo-400'
                : 'bg-slate-700 text-slate-400') }}">
                        {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                    </span>

                    @if ($goal->is_pinned)
                        <span class="text-xs px-2 py-0.5 rounded-full bg-yellow-500/20 text-yellow-400">
                            📌 Pinned
                        </span>
                    @endif
                </div>

                {{-- Deadline --}}
                @if ($goal->target_date)
                    <p class="text-xs text-slate-500 mt-2">
                        🗓 Due {{ $goal->target_date->format('M d, Y') }}
                        @if ($goal->isOverdue())
                            <span class="text-red-400">(Overdue)</span>
                        @endif
                    </p>
                @endif

            </x-card>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $goals->links() }}
    </div>
</x-layout>