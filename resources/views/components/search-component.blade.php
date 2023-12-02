@props(['class' => '','atributes' => []])
 <div class="input__container">
    <input placeholder="Busqueda" type="text" {{ $attributes->merge(['class' => 'input__search ' . $class]) }}>
    <x-icons.search class="input__icon text-primary-dark" />
</div>
