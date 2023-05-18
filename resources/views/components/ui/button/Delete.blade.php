<button class="btn btn-sm text-danger {{ $class ?? '' }}" onclick="return confirm('آیا مطئن هستید؟')">
    @if (!empty($text))
        <span>{{ $text }}</span>
    @else
    <x-ui.icon.Delete />
    @endif
</button>
