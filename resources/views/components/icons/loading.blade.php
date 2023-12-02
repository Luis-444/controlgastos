@props(['class' => '', 'attributes' => [], 'tooltip' => null, 'tooltip_aling' => false])

<div class="relative" x-data="{ tooltip: false }">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" {{ $attributes->merge(['class' => 'icon' . $class]) }} @mouseover="tooltip = true" @mouseleave="tooltip = false" >
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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

