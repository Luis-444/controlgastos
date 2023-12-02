@props(['label' => '', 'for' => '', 'class' => '', 'type' => 'text', 'atributes' => [], 'value'=> ''])


<div>
    @if ($label)
        <label class="block mb-1">{{$label}}</label>
    @endif
    <textarea type="{{$type}}" {{ $attributes->merge(['class' => 'textarea' . $class, 'value' => $value]) }}>{{$value}}</textarea>
    <x-input-error for="{{$for}}" />
</div>
