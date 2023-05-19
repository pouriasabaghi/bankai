<div class="col-md-{{ $col ?? '12' }} mb-3">
    <div class="form-group">
        @if (!empty($label))
            <label class='form-label' for="{{ !empty($id) ? $id : $name }}">{{ $label }}</label>
        @endif
        <input
            @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
                {{ $key . '=' . $attribute }}
            @empty @endforelse
            name="{{ !empty($name) ? $name : '' }}" {{ !empty($type) && $type == 'number' ? 'data-number' : '' }}
            type="{{ !empty($type) ? $type : 'text' }}"
            class="form-control mt-1 text-start {{ !empty($class) ? $class : '' }}"
            placeholder="{{ !empty($placeholder) ? $placeholder : '' }}" autocomplete="off"
            value="{{ !empty($value) ? $value : '' }}" style="{{ $style ?? '' }}">
    </div>
</div>
