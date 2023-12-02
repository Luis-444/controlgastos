<select {!! $attributes->merge(['class' => 'rounded-md']) !!}>
    @for ($i = 5; $i < 100; $i+=10)
        <option value="{{$i}}">{{$i}}</option>
    @endfor
</select>
