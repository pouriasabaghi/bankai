<div>
    @if ($contract->debtorInstallments()->count() >= 3)
        <p class="badge bg-danger">
            بیش از ۲ قسط عقب افتاده
        </p>
    @endif

    @if (jdate()->fromFormat('Y/m/d', $contract->debtorInstallments()->first()->due_at)->toCarbon()->addDays(30) <= now())
        <p class="badge bg-danger">
            {{ now()->diffInDays(
                jdate()->fromFormat('Y/m/d', $contract->debtorInstallments()->first()->due_at)->toCarbon()
            ) }}
            روز گذشته
        </p>
    @endif
    <p>
        <i class="far fa-file-contract"></i>
        قرارداد:
        <span class="fw-bold">{{ $contract->name }}</span>
    </p>
    <p>
        <i class="far fa-hotel"></i>
        مجموعه:
        <span class="fw-bold">{{ $contract->company->name }}</span>
    </p>
    <p>
        <i class="far fa-user"></i>
        مشتری:
        <span class="fw-bold">{{ $contract->customer->name }}</span>
    </p>
    <p>
        <i class="far fa-mobile-screen-button"></i>
        موبایل:
        <span class="fw-bold">{{ $contract->customer->mobile }}</span>
    </p>

    <p>
        تعداد
        <span class="fw-bold">{{ $contract->debtorInstallments()->count() }}</span>
        قسط جمعا به مبلغ
        <span class="fw-bold">{{ number_format($contract->debtorInstallments()->sum('amount')) }}</span>
        <small>تومان</small>
    </p>

    <p>
        بدهکار تا به الآن:
        <span class="fw-bold">{{ (new \App\Services\ReceiveService())->getDetail($contract)['debtor'] }}</span>
        <small>تومان</small>
    </p>

    <p>
        {{ (new \App\Services\ReceiveService())->getDetail($contract)['creditor_title'] }}:
        <span class="fw-bold">{{ (new \App\Services\ReceiveService())->getDetail($contract)['creditor'] }}</span>
        <small>تومان</small>
    </p>
</div>
