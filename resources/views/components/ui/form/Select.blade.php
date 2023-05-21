<div class="col-{{ $col ?? '12' }} mb-3">
    <div class="form-group">
        @if (!empty($label))
            <label class='form-label d-block'>{{ $label }}</label>
        @endif
        <select {{ $livewire ?? '' }} name="{{ $name ?? '' }}"
            class="{{ empty($script) ? 'advance-select' : '' }} {{ $class ?? '' }}">
            {{ $slot }}
        </select>
    </div>
</div>

@if (!empty($script))
    @if ($script != 'no')
        {{ $script }}
    @endif
@endif
