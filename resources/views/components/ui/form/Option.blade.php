<option {{ !empty($disabled) ? 'disabled' : '' }} {{ $selected ? 'selected' : '' }} class="{{ $class ?? '' }}"
    value="{{ $value ?? '' }}">
    {{ $slot }}
</option>
