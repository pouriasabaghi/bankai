<div class="loader" {{ $livewire ?? '' }}
@isset($style)
    style="{{ $style }}"
@endisset>
    <div class="spinner-{{ $type ?? 'border' }} spinner-{{ $type ?? 'border' }}-sm text-{{ $color ?? 'primary' }}{{ $class ?? '' }}">
    </div>
</div>
