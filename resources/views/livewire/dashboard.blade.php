<div>

    <x-dashboard.DashboardTitle>
        داشبورد
        <strong>مدیریت</strong>
    </x-dashboard.DashboardTitle>

    <div class="row">
        <x-ui.loader.Loader livewire="wire:loading.flex"
            style="right: 0;background: #00000040;z-index: 999;height: 100%;position: fixed;" />

        @if (auth()->user()->role != 'user')
            @include('admin.dashboard.layouts.overal')
        @endif

        <div class="col-xl-6 mb-3 ">
            {{-- Debtor contract to call --}}
            @include('admin.dashboard.layouts.contract-card', [
                'contracts' => $contractToCall,
                'type' => 'add',
            ])

            {{-- Not determined contracts --}}
            @include('admin.dashboard.layouts.not-determined', [
                'contracts' => $notDeterminedContracts,
            ])
        </div>


        <div class="col-xl-6 mb-3 ">
            {{-- Debtor contract to remind --}}
            @include('admin.dashboard.layouts.contract-card', [
                'contracts' => $contractNoNeedCall,
                'type' => 'remove',
            ])

            @include('admin.dashboard.layouts.checks')
        </div>

        <div class="col-xl-5">

        </div>


    </div>


</div>
