<x-ui.card.Card class="dashboard-cards shadow-lg ">
    <x-slot name='header'>
        قراردادهای بلاتکلیف
    </x-slot>

    <x-slot name='body'>
        <div class="dashbaord-installments__group">
            @forelse($contracts as $contract)
                <div class="d-inline-block w-100 bg-light shadow-lg p-4 mb-5 ">
                    <div>
                        @if ($contract->debtorInstallments()->count() >= 3)
                            <p class="badge bg-danger">
                                {{ $contract->debtorInstallments()->count() }}
                                قسط عقب افتاده
                            </p>
                        @endif


                        @if ($firstBilledInstallment = $contract->debtorInstallments->first()?->due_at)
                            <p
                                class="badge {{ jdate()->fromFormat('Y/m/d', $firstBilledInstallment)->toCarbon()->addDays(30) < now()
                                    ? 'bg-danger'
                                    : 'bg-warning' }}">
                                {{ now()->diffInDays(
                                    jdate()->fromFormat('Y/m/d', $firstBilledInstallment)->toCarbon(),
                                ) }}
                                روز گذشته
                            </p>
                        @endif

                        <p>
                            <i class="far fa-file-contract"></i>
                            قرارداد:
                            <a href="{{ route('contracts.edit', $contract->id) }}"
                                class="fw-bold">{{ $contract->name }}</a>
                        </p>
                        <p>
                            <i class="far fa-hotel"></i>
                            مجموعه:
                            <span class="fw-bold">{{ $contract->company->name }}</span>
                        </p>

                        <p>
                            <i class="far fa-user"></i>
                            مشتری:
                            <a class="fw-bold"
                                href="{{ route('details.list', ['type' => 'customer', 'id' => $contract->customer->id, 'directory' => 'customers']) }}">
                                {{ $contract->customer->name }}
                            </a>
                        </p>

                        <p>
                            <i class="far fa-mobile-screen-button"></i>
                            موبایل:
                            <span class="fw-bold">{{ $contract->customer->mobile }}</span>
                        </p>

                        <p>
                            <i class="far fa-calendar"></i>
                            تاریخ پایان قرارداد:
                            <span class="fw-bold">{{ $contract->expired_at }}</span>
                        </p>

                        <p>
                            <a href="{{ route('installments.create', $contract->id) }}">
                                تعداد
                                <span class="fw-bold">{{ $contract->debtorInstallments()->count() }}</span>
                                قسط جمعا به مبلغ
                                <span
                                    class="fw-bold">{{ number_format($contract->debtorInstallments()->sum('amount')) }}</span>
                                <small>تومان</small>
                            </a>
                        </p>

                        <p>
                            <a href="{{ route('receives.create', $contract->id) }}">
                                بدهکار تا به الآن:
                                <span
                                    class="fw-bold">{{ (new \App\Services\ReceiveService())->getDetail($contract)['debtor'] }}</span>
                                <small>تومان</small>
                            </a>
                        </p>

                        <p>
                            <a href="{{ route('receives.create', $contract->id) }}">
                                {{ (new \App\Services\ReceiveService())->getDetail($contract)['creditor_title'] }}:
                                <span
                                    class="fw-bold">{{ (new \App\Services\ReceiveService())->getDetail($contract)['creditor'] }}</span>
                                <small>تومان</small>
                            </a>
                        </p>


                    </div>

                </div>
            @empty
                <h5>موردی یافت نشد.</h5>
            @endforelse
        </div>

    </x-slot>
</x-ui.card.Card>
