<div class="form-buttonset">
    @foreach($options as $opValue => $opText)
        {{ null , $opId = $prefix . "-" . array_search($opValue, array_keys($options)) }}
        <input id="{{ $opId }}" type="radio" name="{{ $name }}" class="{{ $class or '' }}"
               value="{{ $opValue }}"
               {{ $other or '' }}
               @if(isset($value) and $value == $opValue)
               checked="checked"
                @endif
        >
        <label for="{{ $opId }}"> {{ $opText }} </label>
    @endforeach
</div>