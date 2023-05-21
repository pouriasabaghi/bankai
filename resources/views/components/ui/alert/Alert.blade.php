<div class="alert alert-{{ $alert ?? 'danger' }} {{ !empty($outline) ? 'alert-outline-coloured ' : '' }}" >
    <div class="alert-icon">
        <i class="far fa-fw fa-{{ $icon ?? 'bell' }}"></i>
    </div>
    <div class="alert-message">
        {{ $slot }}
    </div>
</div>
