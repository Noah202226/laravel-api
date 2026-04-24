<a {{ $attributes->merge(['class' => 'block']) }}>
    <div class="card group hover:scale-[1.02] transition duration-200">

        <div class="space-y-2">
            {{ $slot }}
        </div>

        <div class="mt-4 flex justify-end text-sm text-indigo-400 group-hover:text-indigo-300">
            View Details →
        </div>

    </div>
</a>