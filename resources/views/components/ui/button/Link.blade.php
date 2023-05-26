<a @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
            {{ $key . '=' . $attribute }}
        @empty @endforelse
    href="{{ $href ?? '' }}" class="{{ $class ?? '' }}">

{{ $slot }}

</a>
