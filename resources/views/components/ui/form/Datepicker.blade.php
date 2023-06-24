<div class="col-md-{{ $col ?? '12' }} mb-3">
    <div class="form-group">
        @if (!empty($label))
            <label class="form-label" for="{{ $name }}">{{ $label }}</label>
        @endif
        <input
            @forelse ($attributes = !empty($attr) ? $attr : [] as $key => $attribute  )
                {{ $key . '=' . $attribute }}
            @empty
            @endforelse
            id="{{ $name }}" class="mt-1  form-control {{ $class ?? '' }}" value="{{ $value }}" name="{{ $name }}"
            placeholder="{{ $placeholder ?? '' }}"
            autocomplete='off'
            oninvalid="this.setCustomValidity('این فیلد نمی‌تواند خالی باشد')"
            oninput="setCustomValidity('')"
            />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', ()=>{
        $('input[name="{{$name}}"]').persianDatepicker({
            cellWidth: 32,
            cellHeight: 30,
            fontSize: 16,
            formatDate: "YYYY/0M/0D",

        })

    })
</script>

<style>
    .pdp-header .nextArrow{
        left: 0;
        right: unset;
        transform: rotate(180deg)
    }

    .pdp-header .prevArrow{
        right: 0;
        left: unset;
        transform: rotate(180deg)
    }
</style>
