@if (!empty($href))
    <a href="{{ $href }}" class="btn  btn-{{ $btn ?? 'primary' }} text-white rounded {{ $class ?? '' }}">
        <span>{{ $slot }}</span>
    </a>
@else
    <button {{ !empty($disabled) && $disabled == true ? 'disabled' : '' }} type="{{ $type ?? 'submit' }}"
        class="btn  btn-{{ $btn ?? 'primary' }} text-white rounded {{ $class ?? '' }}" {{ $livewire ?? '' }}>
        <span>{{ $slot }}</span>
    </button>
@endif
