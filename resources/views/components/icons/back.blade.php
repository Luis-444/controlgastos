@props(['class' => '', 'attributes' => [], 'tooltip' => null])

<div class="relative" x-data="{ tooltip: false }">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" {{ $attributes->merge(['class' => 'icon ' . $class]) }}>
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg>
    @if ($tooltip)
        <div x-show="tooltip" class="absolute -top-[170%] -left-[50%] bg-primary-dark text-primary-dark-text rounded-md p-2" style="display: none"><span>{{ $tooltip }}</span></div>
    @endif
</div>
