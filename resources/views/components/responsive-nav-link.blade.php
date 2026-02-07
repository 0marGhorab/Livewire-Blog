@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-brand-primary text-start text-base font-medium text-brand-primary bg-brand-secondary/30 focus:outline-none focus:text-brand-primary focus:bg-brand-secondary/40 focus:border-brand-primary transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-brand-primary/80 hover:text-brand-primary hover:bg-brand-secondary/20 hover:border-brand-primary/40 focus:outline-none focus:text-brand-primary focus:bg-brand-secondary/20 focus:border-brand-primary/40 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
