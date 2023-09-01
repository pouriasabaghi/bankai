<div class="col-xl-3">

    @include('admin.dashboard.layouts.overal-card', [
        'title' => 'قراردادها',
        'data' => $contractsCount,
        'desc' => 'تمام قراردادها',
        'icon' => 'file-text',
    ])
</div>

<div class="col-xl-3">
    @include('admin.dashboard.layouts.overal-card', [
        'title' => 'مشتریان',
        'data' => $customerCount,
        'desc' => 'تمام مشتریان',
        'icon' => 'users',
    ])
</div>

<div class="col-xl-3">
    @include('admin.dashboard.layouts.overal-card', [
        'title' => 'مجموعه‌ها',
        'data' => $companyCount,
        'desc' => 'تمام مجموعه‌ها',
        'icon' => 'users',
    ])
</div>

<div class="col-xl-3">
    @include('admin.dashboard.layouts.overal-card', [
        'title' => 'کنسل شده‌ها',
        'data' => $contractCanceledCount,
        'desc' => 'تمام کنسل شده‌ها',
        'icon' => 'x-square',
    ])
</div>

<div class="col-xl-12">
    <x-ui.alert.Alert alert='success' icon='feather'>
        <p class="mb-0 fw-normal">
            {{-- this variable with View::composer from AppServiceProvider --}}
            <span class="d-flex justify-content-between">
                <span>
                    {{ $motivationalQuote }}
                </span>
                <small>
                    {{ jdate(now())->format('l j F') }}
                </small>
            </span>
        </p>
    </x-ui.alert.Alert>
</div>

<div class="col-xl-6 ">
    <x-ui.alert.Alert alert='warning' icon='dollar'>
        <p class="mb-0 fw-normal">
            مطالبات در انتظار وصول
            {{ $totalDebtor }}
            <small>تومان</small>
        </p>
    </x-ui.alert.Alert>
</div>

<div class="col-xl-6 ">
    <x-ui.alert.Alert alert='info' icon='file-text'>
        <p class="mb-0 fw-normal">
            قراردادهای بلاتکلیف:
            {{ count($notDeterminedContracts) }}
            قرارداد
        </p>
    </x-ui.alert.Alert>
</div>
