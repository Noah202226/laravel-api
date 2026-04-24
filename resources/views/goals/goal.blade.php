<x-layout>
    <div class="max-w-3xl mx-auto">

        <a href="{{ route('goals.goals') }}" class="text-sm text-indigo-400 hover:text-indigo-300 mb-4 inline-block">
            ← Back to Goals
        </a>

        {{-- Header --}}
        <div class="mb-6 flex items-start gap-4">
            @if ($goal->cover_emoji)
                <span class="text-5xl">{{ $goal->cover_emoji }}</span>
            @endif
            <div>
                <h1 class="text-3xl font-bold mb-1">{{ $goal->title }}</h1>
                @if ($goal->category)
                    <span class="text-sm text-indigo-400">{{ $goal->category }}</span>
                @endif
            </div>
        </div>

        {{-- Overall Progress --}}
        <div class="card mb-4">
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-400">Overall Progress</span>
                <span class="font-semibold">{{ $goal->progress }}%</span>
            </div>
            <div class="w-full bg-slate-700 rounded-full h-2">
                <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500"
                    style="width: {{ $goal->progress }}%"></div>
            </div>
        </div>

        {{-- Motivation Section --}}
        @if ($goal->purpose || $goal->dream_outcome || $goal->fear_of_not_doing)
            <div class="card mb-4 space-y-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wide">Why This Goal</h2>

                @if ($goal->purpose)
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">Purpose</p>
                        <p class="text-sm">{{ $goal->purpose }}</p>
                    </div>
                @endif

                @if ($goal->goal_for)
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">This goal is for</p>
                        <p class="text-sm">{{ $goal->goal_for }}</p>
                    </div>
                @endif

                @if ($goal->dream_outcome)
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">Dream outcome</p>
                        <p class="text-sm">{{ $goal->dream_outcome }}</p>
                    </div>
                @endif

                @if ($goal->fear_of_not_doing)
                    <div>
                        <p class="text-xs text-slate-500 mb-0.5">Cost of not doing it</p>
                        <p class="text-sm text-red-400">{{ $goal->fear_of_not_doing }}</p>
                    </div>
                @endif

                @if ($goal->motivation_quote)
                    <blockquote class="border-l-2 border-indigo-500 pl-3 italic text-slate-300 text-sm">
                        "{{ $goal->motivation_quote }}"
                    </blockquote>
                @endif
            </div>
        @endif

        {{-- Reward --}}
        @if ($goal->reward)
            <div class="card mb-4 flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 mb-0.5">🎁 Reward on completion</p>
                    <p class="text-sm font-medium">{{ $goal->reward }}</p>
                </div>
                @if ($goal->reward_claimed)
                    <span class="text-xs px-2 py-1 bg-green-500/20 text-green-400 rounded-full">Claimed ✓</span>
                @else
                    <span class="text-xs px-2 py-1 bg-slate-700 text-slate-400 rounded-full">Not yet claimed</span>
                @endif
            </div>
        @endif

        {{-- Steps & Tasks --}}
        <div class="mb-6">
            <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wide mb-3">Steps & Tasks</h2>

            @forelse ($goal->steps as $step)
                    <div class="card mb-3">

                        {{-- Step Header --}}
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500 font-mono">{{ $loop->iteration }}</span>
                                <h3 class="font-semibold">{{ $step->title }}</h3>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                    {{ $step->status === 'completed' ? 'bg-green-500/20 text-green-400'
                : ($step->status === 'in_progress' ? 'bg-indigo-500/20 text-indigo-400'
                    : 'bg-slate-700 text-slate-400') }}">
                                {{ ucfirst(str_replace('_', ' ', $step->status)) }}
                            </span>
                        </div>

                        {{-- Step progress bar --}}
                        <div class="w-full bg-slate-700 rounded-full h-1 mb-3">
                            <div class="bg-indigo-500 h-1 rounded-full transition-all duration-500"
                                style="width: {{ $step->progress }}%"></div>
                        </div>

                        {{-- Tasks --}}
                        @if ($step->tasks->isNotEmpty())
                            <ul class="space-y-3">
                                @foreach ($step->tasks as $task)
                                        <li class="flex items-start gap-3 pl-1">

                                            {{-- Task toggle form --}}
                                            <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="flex-shrink-0 mt-0.5">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-5 h-5 rounded border flex items-center justify-center transition-colors
                                                                        {{ $task->status === 'completed'
                                    ? 'bg-indigo-500 border-indigo-500 hover:bg-indigo-600'
                                    : 'border-slate-600 hover:border-indigo-400' }}">
                                                    @if ($task->status === 'completed')
                                                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 10 8">
                                                            <path d="M1 4l3 3 5-6" stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                            <div class="flex-1">
                                                {{-- Task title --}}
                                                <p class="text-sm {{ $task->status === 'completed' ? 'line-through text-slate-500' : '' }}">
                                                    {{ $task->title }}
                                                </p>

                                                {{-- Subtasks --}}
                                                @if ($task->subtasks->isNotEmpty())
                                                    <ul class="mt-2 space-y-1.5 pl-3 border-l border-slate-700">
                                                        @foreach ($task->subtasks as $subtask)
                                                                    <li class="flex items-center gap-2">

                                                                        {{-- Subtask toggle form --}}
                                                                        <form method="POST" action="{{ route('subtasks.toggle', $subtask) }}">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit"
                                                                                class="w-4 h-4 rounded border flex items-center justify-center transition-colors flex-shrink-0
                                                                                                            {{ $subtask->is_completed
                                                            ? 'bg-indigo-500 border-indigo-500 hover:bg-indigo-600'
                                                            : 'border-slate-600 hover:border-indigo-400' }}">
                                                                                @if ($subtask->is_completed)
                                                                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 10 8">
                                                                                        <path d="M1 4l3 3 5-6" stroke="currentColor" stroke-width="1.5"
                                                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                                                    </svg>
                                                                                @endif
                                                                            </button>
                                                                        </form>

                                                                        <span
                                                                            class="text-xs {{ $subtask->is_completed ? 'line-through text-slate-500' : 'text-slate-400' }}">
                                                                            {{ $subtask->title }}
                                                                        </span>

                                                                    </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>

                                            {{-- Priority badge --}}
                                            @if ($task->priority === 'high')
                                                <span class="text-xs text-red-400 flex-shrink-0 mt-0.5">High</span>
                                            @endif

                                        </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
            @empty
                <p class="text-sm text-slate-500">No steps added yet.</p>
            @endforelse
        </div>

        {{-- Meta: dates + status --}}
        <div class="card mb-4 grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Status</p>
                <span
                    class="px-2 py-0.5 rounded-full text-xs
                    {{ $goal->status === 'completed' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                    {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                </span>
            </div>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Priority</p>
                <p>{{ ucfirst($goal->priority) }}</p>
            </div>
            @if ($goal->start_date)
                <div>
                    <p class="text-xs text-slate-500 mb-0.5">Start date</p>
                    <p>{{ $goal->start_date->format('M d, Y') }}</p>
                </div>
            @endif
            @if ($goal->target_date)
                <div>
                    <p class="text-xs text-slate-500 mb-0.5">Target date</p>
                    <p class="{{ $goal->isOverdue() ? 'text-red-400' : '' }}">
                        {{ $goal->target_date->format('M d, Y') }}
                        @if ($goal->isOverdue()) (Overdue) @endif
                    </p>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <a href="/goals/{{ $goal->id }}/edit" class="btn btn-primary">Edit Goal</a>

            <form method="POST" action="/goals/{{ $goal->id }}">
                @csrf
                @method('DELETE')
                <button class="btn bg-red-500 hover:bg-red-600 text-white">Delete</button>
            </form>
        </div>

    </div>
</x-layout>