{{-- Showing detail total_price, priods and sum current installments --}}

<div class="row mb-3">
    <div class="col-md-6 col-xl-4 mb-3 mb-md-0 d-flex flex-column">
        <h6>
            <i class="fa-solid fa-circle-info fa-lg"></i>
            اطلاعات قرارداد
        </h6>
        <div class="row mx-0">
           <div class="col-12 py-2 d-flex flex-column  bg-light receives-contract-information">
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-solid fa-file-invoice-dollar "></i>
                        عنوان قرارداد:</div>
                    <div class="col-6">{{ $contract->name }}</div>
                </div>
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-solid fa-user-tie"></i>
                        مشتری:</div>
                    <div class="col-6">{{ $contract->customer->name }}</div>
                </div>
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-solid fa-building-columns"></i>
                        مجموعه:</div>
                    <div class="col-6">{{ $contract->company->name }}</div>
                </div>
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-regular fa-star"></i>
                        دسته بندی خدمات:</div>
                    <div class="col-6">{{ $contract->type }}</div>
                </div>
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-regular fa-star"></i>
                        خدمات</div>
                    <div class="col-6">{{ $contract->services->pluck('name')->implode(', ') }}</div>
                </div>
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-regular fa-handshake"></i>
                        تاریخ امضای قرارداد</div>
                    <div class="col-6">{{ $contract->signed_at }}</div>
                </div>
                @if ($contract->canceled_at)
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-solid fa-power-off"></i>
                        تاریخ لغو قرارداد</div>
                    <div class="col-6">{{ $contract->canceled_at }}</div>
                </div>
                @endif
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-regular fa-calendar"></i>
                     مدت قرارداد
                    </div>
                    <div class="col-6">{{ $contract->period }}</div>
                </div>
                <div class="row ">
                    <div class="col-6">
                        <i class="fa-solid fa-sack-dollar"></i>
                       مبلغ کل قرارداد
                    </div>
                    <div class="col-6">{{ $contract->total_price_str }}</div>
                </div>
           </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4 mb-3 mb-md-0  d-flex flex-column">
        <h6>
            <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
            اقساط
        </h6>
        <ul class="list-group list-group-horizontal list-group-normalize list-group-thin mx-md-0">
            <li class="list-group-item list-group-item-danger list-group-installments-customer-status">
                <div>بدهکار تا به الآن:</div>
                <span>{{ $debtor }}</span>
                <small>تومان</small>
            </li>
            <li class="list-group-item list-group-item-info list-group-installments-customer-status">
                <div>{{ $creditorTitle }}:</div>
                <span>{{ $creditor }}</span>
                <small>تومان</small>
            </li>
        </ul>
        @foreach ($installments as $installment)
            <ul class="list-group list-group-horizontal list-group-installments mx-md-0">
                <li class=" list-group-item {{ $installment->status_class }}">
                    <span>{{ $loop->index + 1 }}</span>
                </li>
                <li class=" list-group-item {{ $installment->status_class }}">
                    <span>{{ $installment->amount_str }}</span>
                </li>
                <li class=" list-group-item {{ $installment->status_date_class }}">
                    <span>{{ $installment->due_at }}</span>
                </li>
            </ul>
        @endforeach

    </div>

    <div class="col-md-6 col-xl-4 mb-3 mb-md-0 px-0  d-flex flex-column">
        <h6>
            <i class="fa-regular fa-money-bill-transfer fa-lg"></i>
            دریافتی‌ها
        </h6>
        @foreach ($contractReceives as $receive)
            <ul class="list-group list-group-horizontal list-group-installments mx-md-0">
                <li class=" list-group-item list-group-item-success ">
                    <span>{{ $loop->index + 1 }}</span>
                </li>
                <li class=" list-group-item list-group-item-success ">
                    <span>{{ $receive->amount_str }}</span>
                </li>
                <li class=" list-group-item list-group-item-success ">
                    <span>{{ $receive->date }}</span>
                </li>
                <li class=" list-group-item list-group-item-success ">
                    <span>{{ $receive->type_str }}</span>
                </li>
            </ul>
        @endforeach
    </div>
</div>
