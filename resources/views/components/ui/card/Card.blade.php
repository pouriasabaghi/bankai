<div class="card"
@if (!empty($id))
    id="{{ $id }}"
@endif
>
    @if (!empty($header))
        <div class="card-header">
            <h5 class="card-title ">{{ $header }}</h5>
            @if (!empty($subtitle))
                <h6 class="card-subtitle text-muted">{{ $subtitle }}</h6>
            @endif
        </div>
    @endif

    @if (!empty($body))
        <div class="card-body">
            {{ $body }}
        </div>
    @endif
    {{ $slot }}
</div>
