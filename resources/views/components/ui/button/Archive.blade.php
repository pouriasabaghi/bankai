<button
    title="{{ $title ?? '' }}"
    @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
        {{ $key . '=' . $attribute }}
    @empty @endforelse
    class="btn btn-sm text-info {{ $class ?? '' }}" onclick="return confirm('آیا مطئن هستید؟')">
    @if (!empty($text))
        <span>{{ $text }}</span>
    @else
        <x-ui.icon.Archive archived="{{ $archived }}" />
    @endif
</button>
