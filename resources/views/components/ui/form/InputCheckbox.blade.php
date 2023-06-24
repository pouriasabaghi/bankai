<div class="form-check {{ $labelClass ?? '' }}">
    @if (!empty($label))
    <label class="form-check-label cursor-pointer {{ !empty($nomargin) ? 'mb-0' : 'mb-3' }}" for="{{ $id ?? ($name ?? '') }}">
        {{ $label }}
    </label>
@endif


    <input
        @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
        {{ $key . '=' . $attribute }}
    @empty @endforelse
        name="{{ !empty($name) ? $name : '' }}"
        type="{{ !empty($type) ? $type : 'checkbox' }}"
        class=" {{ !empty($class) ? $class : '' }}"
        value="{{ !empty($value) ? $value : '' }}" style="{{ $style ?? '' }}"
        id="{{ $id ?? ($name ?? '') }}"
        {{ !empty($checked) && $checked == true ? 'checked' : '' }}
        >


</div>
