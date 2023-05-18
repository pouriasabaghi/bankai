<a href="{{ $herf ?? '#' }}" class="btn btn-sm text-info {{ $class ?? '' }}">

    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <x-ui.icon.Edit />
    @endif

</a>
