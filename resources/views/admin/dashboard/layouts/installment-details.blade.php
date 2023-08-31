<div>
    @if ($contract->debtorInstallments()->count() >= 3)
        <p class="badge bg-danger">
            {{ $contract->debtorInstallments()->count()  }}
            قسط عقب افتاده
        </p>
    @endif


    @php
        $firstBilledInstallment = $contract->debtorInstallments->first()->due_at;
    @endphp
    <p class="badge {{ jdate()->fromFormat('Y/m/d', $firstBilledInstallment)->toCarbon()->addDays(30) < now()
        ? 'bg-danger'
        : 'bg-warning'
    }}">
        {{ now()->diffInDays(
            jdate()->fromFormat('Y/m/d', $firstBilledInstallment)->toCarbon(),
        ) }}
        روز گذشته
    </p>

    <p>
        <i class="far fa-file-contract"></i>
        قرارداد:
        <a href="{{ route('contracts.update', $contract->id) }}" class="fw-bold">{{ $contract->name }}</a>
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
