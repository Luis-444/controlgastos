@props(['input_id'=> '', 'disabled_input' => false ,'label' => '', 'for' => '', 'class' => '', 'type' => 'text', 'atributes' => []])

@if ($type == "file")
    <div class="relative w-full">
        <label class="rounded-md block p-2 button-primary w-full text-center cursor-pointer" for="{{$input_id}}">{{$label}}</label>
        <input autocomplete="off" {{ $disabled_input ? "disabled" : ""}} id="{{$input_id}}" type="{{$type}}" {{ $attributes->merge(['class' => 'hidden ' . $class]) }}>
    </div>
@else
    <div class="flex-1 text-left">
        @if ($label)
            <label class="block mb-1">{{$label}}</label>
        @endif
        <div class="flex__container space-x-2">
            <input autocomplete="off" {{ $disabled_input ? "disabled" : ""}} {{ $input_id ? 'id="'.$input_id.'"' : '' }} type="{{$type}}" {{ $attributes->merge(['class' => 'input ' . $class]) }}>
            @isset($buttonSlot)
                {{ $buttonSlot }}
            @endisset
        </div>
        <x-input-error for="{{$for}}" />
    </div>
@endif
