<div class="col-xl-3">
    <x-ui.card.Card>
        <x-slot name='header'>
            <div class="d-flex justify-content-between align-items-center">
                <span>قراردادها</span>
                <div class="stat text-primary">
                    <span data-feather="file-text"></span>
                </div>
            </div>
        </x-slot>

        <x-slot name='body'>
            <span class="mt-1 mb-3 h1">{{ $contractsCount }}</span>
            <div class="mb-0">
                <span class="text-muted">نسبت به سال گذشته</span>
                <span class="badge badge-{{ $balanceImprovement ? 'success' : 'danger' }}-light">
                    <i class="mdi mdi-arrow-bottom-right"></i>
                    {{ $balancePercent }}%
                </span>
            </div>
        </x-slot>

    </x-ui.card.Card>
</div>

<div class="col-xl-3">
    <x-ui.card.Card>
        <x-slot name='header'>
            <div class="d-flex justify-content-between align-items-center">
                <span> مشتریان</span>
                <div class="stat text-primary">
                    <span data-feather="users"></span>
                </div>
            </div>
        </x-slot>

        <x-slot name='body'>
            <span class="mt-1 mb-3 h1">{{ $customerCount }}</span>
            <div class="mb-0">
                <span class="text-muted">تمام مشتریان</span>
            </div>
        </x-slot>

    </x-ui.card.Card>
</div>

<div class="col-xl-3">
    <x-ui.card.Card>
        <x-slot name='header'>
            <div class="d-flex justify-content-between align-items-center">
                <span> مجموعه‌ها</span>
                <div class="stat text-primary">
                    <span data-feather="umbrella"></span>
                </div>
            </div>
        </x-slot>

        <x-slot name='body'>
            <span class="mt-1 mb-3 h1">{{ $companyCount }}</span>
            <div class="mb-0">
                <span class="text-muted">تمام مجموعه‌ها</span>
            </div>
        </x-slot>

    </x-ui.card.Card>
</div>

<div class="col-xl-3">
    <x-ui.card.Card>
        <x-slot name='header'>
            <div class="d-flex justify-content-between align-items-center">
                <span>کنسل‌ شده</span>
                <div class="stat text-primary">
                    <span data-feather="x-square"></span>
                </div>
            </div>
        </x-slot>

        <x-slot name='body'>
            <span class="mt-1 mb-3 h1">{{ $contractCanceledCount }}</span>
            <div class="mb-0">
                <span class="text-muted">تمام کنسلی‌ها</span>
            </div>
        </x-slot>

    </x-ui.card.Card>
</div>

<div class="col-12">
    <x-ui.alert.Alert alert='warning' icon='dollar'>
        <p class="mb-0 fw-normal">
            در مجموع
            {{ $totalDebtor }}
            <small>تومان</small>
        </p>
    </x-ui.alert.Alert>
</div>
