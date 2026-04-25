@props(['value'])

<label {{ $attributes }}>
    <span class="block text-xs text-slate-400 mb-1">{{ $value ?? $slot }}</span>
</label>