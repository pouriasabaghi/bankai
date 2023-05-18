<button class="btn btn-sm text-danger {{ $class ?? '' }}">
    @if (!empty($text))
        <span>{{ $text }}</span>
    @else
    <x-ui.icon.Delete />
    @endif
</button>
