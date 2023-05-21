<option {{ !empty($disabled) ? 'disabled' : '' }} {{ !empty($selected) ? 'selected' : '' }} class="{{ $class ?? '' }}"
    value="{{ $value ?? '' }}" data-value="{{ $value ?? 0 }}">
    {{ $slot }}
</option>
