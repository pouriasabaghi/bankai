<option {{ !empty($disabled) ? "disabled" : "" }} class="{{ $class ?? '' }}" value="{{ $value ?? '' }}">
    {{ $slot }}
</option>
