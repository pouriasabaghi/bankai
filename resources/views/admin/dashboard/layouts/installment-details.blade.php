<div>
    @if (count($installments) >= 3)
    <p class="badge bg-danger">
       بیش از ۲ قسط عقب افتاده
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
    <div>
        تعداد
        <span class="fw-bold">{{ $installments->count() }}</span>
        قسط جمعا به مبلغ
        <span class="fw-bold">{{ number_format($installments->sum('amount')) }}</span>
        <small>تومان</small>
    </div>
</div>


