<x-ui.alert.Alert alert='warning' icon='dollar'>
    <p class="mb-0 fw-normal">
        {{ $text ?? 'جمع کل:' }}
        {{ $total }}
        <small>تومان</small>
    </p>
</x-ui.alert.Alert>
