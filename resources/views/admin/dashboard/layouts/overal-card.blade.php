<x-ui.card.Card>
    <x-slot name='header'>
        <div class="d-flex justify-content-between align-items-center">
            <span>{{ $title }}</span>
            <div class="stat text-primary">
                <span data-feather="{{ $icon }}"></span>
            </div>
        </div>
    </x-slot>

    <x-slot name='body'>
        <span class="mt-1 mb-3 h1">{{ $data }}</span>
        <div class="mb-0">
            <span class="text-muted">{{ $desc ?? '' }}</span>
        </div>
    </x-slot>

</x-ui.card.Card>
