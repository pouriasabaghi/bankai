<div class="col-{{ $col ?? '12' }} mb-3">
    <div class="form-group">
        @if (!empty($label))
            <label class='form-label d-block'>{{ $label }}</label>
        @endif
        <select name="{{ $name ?? '' }}" class="{{ empty($script) ? 'advance-select' : '' }} {{ $class ?? '' }}">
            {{ $slot }}
        </select>
    </div>
</div>

@if (!empty($script))
    {{ $script }}
@endif
