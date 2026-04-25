<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary w-full justify-center']) }}>
    {{ $slot }}
</button>