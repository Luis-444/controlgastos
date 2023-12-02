@props(['label' => '', 'for' => '', 'class' => '', 'value' => 'id', 'useItem' => false, 'text' => 'name', 'default_option' => 'Selecciona una opcion','not_initial_option'=>false, 'attributes' => [], 'items' => []])
<div class="flex flex-col justify-center">
    @if ($label)
        <label class="mb-1">{{$label}}</label>
    @endif
    <div class="flex__container space-x-2">
        <select style="padding: 0 40px 0 10px;" {{ $attributes->merge(['class' => 'input min-h-[42px] max-h-[42px] ' . $class]) }}>
            @if (!$not_initial_option)
                <option value="{{null}}">{{ $default_option }}</option>
            @endif
            @foreach($items as $item)
                <option value="{{$useItem ? $item : $item[$value]}}">{{$item[$text]}}</option>
            @endforeach
        </select>
        @isset($button_slot)
            {{$button_slot}}
        @endisset
    </div>

    @if ($for)
        <x-input-error for="{{ $for }}" />
    @endif
</div>
