@props(['class' => '', 'attributes' => [], 'tooltip' => null, 'tooltip_aling' => false])

<div class="relative" x-data="{ tooltip: false }">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" {{ $attributes->merge(['class' => 'icon ' . $class]) }} @mouseover="tooltip = true" @mouseleave="tooltip = false" >
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>

    @if ($tooltip)
        <div x-show="tooltip" x-transition class="absolute -left-[50%] bg-primary-dark text-primary-dark-text rounded-md p-2 truncate"
            style="
                display: none;
                top: {{ $tooltip_aling == "top" ? "-170%" : "170%"}}
                ">
        <span>{{ $tooltip }}</span></div>
    @endif

</div>
