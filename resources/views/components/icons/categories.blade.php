@props(['class' => '', 'attributes' => [], 'tooltip' => null])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" {{ $attributes->merge(['class' => 'icon ' . $class]) }}>
  <path fill-rule="evenodd" d="M2 3.75A.75.75 0 012.75 3h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 3.75zm0 4.167a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75zm0 4.166a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75zm0 4.167a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
</svg>

@if ($tooltip)
    <div class="tooltip"><span>{{ $tooltip }}</span></div>
@endif
