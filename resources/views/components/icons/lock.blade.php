@props(['class' => '', 'attributes' => [], 'tooltip' => null, 'tooltip_aling' => false])

<div class="relative" x-data="{ tooltip: false }">

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"  {{ $attributes->merge(['class' => 'icon ' . $class]) }} @mouseover="tooltip = true" @mouseleave="tooltip = false" >
    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
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

