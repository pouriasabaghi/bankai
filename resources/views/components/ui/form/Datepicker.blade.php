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
            id="{{ $name }}" class="mt-1  form-control" value="{{ $value }}" name="{{ $name }}"
            readonly />
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
