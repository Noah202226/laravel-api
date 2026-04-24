<x-layout>
    <div class="max-w-2xl mx-auto">

        <a href="{{ route('goals.goal', $goal->id) }}"
           class="text-sm text-indigo-400 hover:text-indigo-300 mb-4 inline-block">
            ← Back to Goal
        </a>

        <h1 class="text-2xl font-bold mb-6">Edit Goal</h1>

        <form method="POST" action="{{ route('goals.update', $goal->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Core --}}
            <div class="card space-y-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wide">The Goal</h2>

                {{-- Emoji + Color --}}
                <div class="flex gap-3">
                    <div class="w-1/4">
                        <label class="block text-xs text-slate-400 mb-1">Emoji</label>
                        <input type="text" name="cover_emoji"
                               value="{{ old('cover_emoji', $goal->cover_emoji) }}"
                               placeholder="🚀"
                               class="input w-full text-center text-2xl" maxlength="2">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs text-slate-400 mb-1">Card Color</label>
                        <div class="flex gap-2 flex-wrap mt-1">
                            @foreach ([
                                '#6C63FF' => 'Indigo',
                                '#10B981' => 'Green',
                                '#F59E0B' => 'Amber',
                                '#EF4444' => 'Red',
                                '#3B82F6' => 'Blue',
                                '#EC4899' => 'Pink',
                            ] as $hex => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="cover_color" value="{{ $hex }}"
                                           class="sr-only peer"
                                           {{ old('cover_color', $goal->cover_color) === $hex ? 'checked' : '' }}>
                                    <span class="block w-7 h-7 rounded-full border-2 border-transparent
                                                 peer-checked:border-white transition"
                                          style="background-color: {{ $hex }}"
                                          title="{{ $label }}"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Goal title <span class="text-red-400">*</span></label>
                    <input type="text" name="title"
                           value="{{ old('title', $goal->title) }}"
                           class="input w-full @error('title') border-red-500 @enderror" required>
                    @error('title')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Description</label>
                    <textarea name="description" rows="2"
                              class="input w-full resize-none">{{ old('description', $goal->description) }}</textarea>
                </div>

                {{-- Category + Priority --}}
                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="block text-xs text-slate-400 mb-1">Category</label>
                        <select name="category" class="input w-full">
                            <option value="">— None —</option>
                            @foreach (['Career', 'Business', 'Health', 'Finance', 'Education', 'Personal'] as $cat)
                                <option value="{{ $cat }}"
                                    {{ old('category', $goal->category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs text-slate-400 mb-1">Priority</label>
                        <select name="priority" class="input w-full">
                            @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('priority', $goal->priority) === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Status</label>
                    <select name="status" class="input w-full">
                        @foreach ([
                            'not_started' => 'Not Started',
                            'in_progress' => 'In Progress',
                            'completed'   => 'Completed',
                            'paused'      => 'Paused',
                            'abandoned'   => 'Abandoned',
                        ] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('status', $goal->status) === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dates --}}
                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="block text-xs text-slate-400 mb-1">Start date</label>
                        <input type="date" name="start_date"
                               value="{{ old('start_date', $goal->start_date?->format('Y-m-d')) }}"
                               class="input w-full">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs text-slate-400 mb-1">Target date</label>
                        <input type="date" name="target_date"
                               value="{{ old('target_date', $goal->target_date?->format('Y-m-d')) }}"
                               class="input w-full">
                    </div>
                </div>

                {{-- Pin --}}
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="is_pinned" value="1"
                           {{ old('is_pinned', $goal->is_pinned) ? 'checked' : '' }}
                           class="w-4 h-4 accent-indigo-500">
                    <span class="text-sm text-slate-300">📌 Pin this goal to the top</span>
                </label>
            </div>

            {{-- Motivation --}}
            <div class="card space-y-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wide">Why This Goal?</h2>

                <div>
                    <label class="block text-xs text-slate-400 mb-1">Purpose</label>
                    <textarea name="purpose" rows="2"
                              class="input w-full resize-none">{{ old('purpose', $goal->purpose) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">This goal is for</label>
                    <input type="text" name="goal_for"
                           value="{{ old('goal_for', $goal->goal_for) }}"
                           class="input w-full">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Dream outcome</label>
                    <textarea name="dream_outcome" rows="2"
                              class="input w-full resize-none">{{ old('dream_outcome', $goal->dream_outcome) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Cost of NOT doing this</label>
                    <textarea name="fear_of_not_doing" rows="2"
                              class="input w-full resize-none">{{ old('fear_of_not_doing', $goal->fear_of_not_doing) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Personal mantra or quote</label>
                    <input type="text" name="motivation_quote"
                           value="{{ old('motivation_quote', $goal->motivation_quote) }}"
                           class="input w-full">
                </div>
            </div>

            {{-- Reward --}}
            <div class="card space-y-4">
                <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wide">🎁 Your Reward</h2>

                <div>
                    <label class="block text-xs text-slate-400 mb-1">Reward</label>
                    <input type="text" name="reward"
                           value="{{ old('reward', $goal->reward) }}"
                           class="input w-full">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Reward type</label>
                    <select name="reward_type" class="input w-full">
                        <option value="">— None —</option>
                        @foreach (['experience' => '✈️ Experience', 'item' => '🛍️ Item', 'rest' => '😴 Rest', 'treat' => '🍕 Treat'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('reward_type', $goal->reward_type) === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('goals.goal', $goal->id) }}"
                   class="btn bg-slate-700 hover:bg-slate-600 text-white">Cancel</a>
            </div>

        </form>

        {{-- Danger Zone --}}
        <div class="card mt-6 border border-red-500/20">
            <h2 class="text-sm font-semibold text-red-400 mb-3">Danger Zone</h2>
            <p class="text-xs text-slate-500 mb-3">
                Deleting this goal will also remove all its steps, tasks, and subtasks. This cannot be undone.
            </p>
            <form method="POST" action="{{ route('goals.destroy', $goal->id) }}">
                @csrf @method('DELETE')
                <button type="submit"
                        class="btn bg-red-500 hover:bg-red-600 text-white text-sm"
                        onclick="return confirm('Delete this goal and everything inside it?')">
                    Delete Goal Permanently
                </button>
            </form>
        </div>

    </div>
</x-layout>