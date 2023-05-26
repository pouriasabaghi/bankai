@if (!empty($href))
    <a
        @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
            {{ $key . '=' . $attribute }}
        @empty @endforelse

        href="{{ $href }}" class="btn  btn-{{ $btn ?? 'primary' }} text-white rounded {{ $class ?? '' }}">
        <span>{{ $slot }}</span>
    </a>
@else
    <button {{ !empty($disabled) && $disabled == true ? 'disabled' : '' }} type="{{ $type ?? 'submit' }}"
        @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
            {{ $key . '=' . $attribute }}
        @empty @endforelse
        class="btn  btn-{{ $btn ?? 'primary' }} text-white rounded {{ $class ?? '' }}" {{ $livewire ?? '' }}>
        <span>{{ $slot }}</span>
    </button>
@endif
