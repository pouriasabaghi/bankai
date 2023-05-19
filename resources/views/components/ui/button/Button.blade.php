@if (!empty($href))
    <a href="{{ $href }}" class="btn  btn-{{ $btn ?? 'primary' }} text-white rounded {{ $class ?? '' }}">
        <span>{{ $slot }}</span>
    </a>
@else
    <button class="btn  btn-{{ $btn ?? 'primary' }} text-white rounded {{ $class ?? '' }}">
        <span>{{ $slot }}</span>
    </button>
@endif
