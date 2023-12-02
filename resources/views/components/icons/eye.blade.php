@props(['class' => '', 'attributes' => [], 'tooltip' => null, 'tooltip_aling' => false])

<div class="relative" x-data="{ tooltip: false }">

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"  @mouseover="tooltip = true" @mouseleave="tooltip = false" {{ $attributes->merge(['class' => 'icon ' . $class])  }}>
        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
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
