@props(['divider_class' => 'border-primary', 'text_class' => 'p-2 text-lg'])
<hr class="{{ $divider_class }}">
    <p class="{{ $text_class }}">{{ $slot }}</p>
<hr class="{{ $divider_class }}">
