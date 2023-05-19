<div class="mb-3 row">
    @if (!empty($label))
        <label class='col-form-label col-sm-2 text-sm-end'
            for="{{ !empty($id) ? $id : $name }}">{{ !empty($label) ? $label : '' }}</label>
    @endif
    <div class="col-sm-10">
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
