<option {{ !empty($disabled) ? 'disabled' : '' }} {{ !empty($selected) ? 'selected' : '' }} class="{{ $class ?? '' }}"
    value="{{ $value ?? '' }}">
    {{ $slot }}
</option>
