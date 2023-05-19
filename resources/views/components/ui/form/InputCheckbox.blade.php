<div class="form-check">
    <input
        @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
        {{ $key . '=' . $attribute }}
    @empty @endforelse
        name="{{ !empty($name) ? $name : '' }}"
        type="{{ !empty($type) ? $type : 'checkbox' }}"
        class=" {{ !empty($class) ? $class : '' }}"
        value="{{ !empty($value) ? $value : '' }}" style="{{ $style ?? '' }}"
        id="{{ $name }}"
        >

    @if (!empty($label))
        <label class="form-check-label mb-3" for="{{ $name }}">
            {{ $label }}
        </label>
    @endif
</div>
