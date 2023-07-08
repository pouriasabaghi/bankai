{{-- Showing detail total_price, priods and sum current installments --}}

<div class="row mb-3">
    <div class="col-md-6 col-xl-9 mb-3 mb-md-0 d-flex flex-column">
        <h6>
            <i class="fa-solid fa-circle-info fa-lg"></i>
            {{ $contract->name }}
        </h6>
        <div class="row mx-0">
            <div class="col-12 py-2 d-flex flex-column  bg-light receives-contract-information">
                <div class="row" style="font-size: 12px">
                    <div class="col-6 col-xl-2 mb-3 border-2 border-end pe-2">
                        <i class="fa-solid fa-file-signature"></i>
                         امضای قرارداد
                    </div>
                    <div class="col-6 col-xl-2 mb-3 ">{{ $contract->signed_at }}</div>


                    <div class="col-6 col-xl-2 mb-3 border-2 border-end pe-2">
                        <i class="fa-regular fa-handshake"></i>
                         شروع قرارداد
                    </div>
                    <div class="col-6 col-xl-2 mb-3 ">{{ $contract->started_at }}</div>

                    @if ($contract->canceled_at)
                        <div class="col-6 col-xl-2 mb-3 border-2 border-end pe-2">
                            <i class="fa-solid fa-power-off"></i>
                             لغو قرارداد
                        </div>
                        <div class="col-6 col-xl-2 mb-3 ">{{ $contract->canceled_at }}</div>
                    @endif


                    <div class="col-6 col-xl-2 mb-3 border-2 border-end pe-2 ">
                        <i class="fa-solid fa-user-tie"></i>
                        مشتری:
                    </div>
                    <div class="col-6 col-xl-2 mb-3 ">{{ $contract->customer->name }}</div>


                    <div class="col-6 col-xl-2 mb-3 border-2 border-end pe-2">
                        <i class="fa-solid fa-building-columns"></i>
                        مجموعه:
                    </div>
                    <div class="col-6 col-xl-2 mb-3 ">{{ $contract->company->name }}</div>


                    <div class="col-6 col-xl-2 mb-3 border-2 border-end pe-2">
                        <i class="fa-regular fa-star"></i>
                        دسته بندی خدمات:
                    </div>
                    <div class="col-6 col-xl-2 mb-3 ">{{ $contract->type }}</div>


                    <div class="col-6 col-xl-2 mb-3 border-2 border-end pe-2">
                        <i class="fa-regular fa-star"></i>
                        خدمات
                    </div>
                    <div class="col-6 col-xl-2 mb-3 ">{{ $contract->services->pluck('name')->implode(', ') }}</div>

                    <div class="col-6 col-xl-2 border-2 border-end pe-2">
                        <i class="fa-regular fa-calendar"></i>
                        مدت قرارداد
                    </div>
                    <div class="col-6 col-xl-2 ">{{ $contract->period }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-3 mb-md-0  d-flex flex-column">
        <h6>
            <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
            ترازمالی
        </h6>

        <div class="row mx-0 p-2 bg-light " style="font-size: 12px">
            <div class="row mx-0 px-0 border-2 border-bottom">
                <div class="col-6 pb-3">
                    <span>مبلغ کل قرارداد:</span>
                </div>
                <div class="col-6">
                    <span>{{ $contract->total_price_str }}</span>
                    <small>تومان</small>
                </div>
            </div>

            <div class="row mx-0 px-0 border-2 border-bottom py-3 ">
                <div class="col-6">
                    <span>بدهی تا به الان:</span>
                </div>
                <div class="col-6">
                    <span>{{ $debtor }}</span>
                    <small>تومان</small>
                </div>
            </div>

            <div class="row mx-0 px-0 border-2 border-bottom py-3">
                <div class="col-6 ">
                    <span>{{ $creditorTitle }}:</span>
                </div>
                <div class="col-6">
                    <span>{{ $creditor }}</span>
                    <small>تومان</small>
                </div>
            </div>


            <div class="row mx-0 px-0 border-2 border-bottom py-3">
                <div class="col-6 ">
                    <span>جمع کل دریافتی‌ها:</span>
                </div>
                <div class="col-6">
                    <span> {{ number_format(collect($contractReceives)->sum('amount')) }} </span>
                    <small>تومان</small>
                </div>
            </div>


            <div class="row mx-0 px-0 pt-3 ">
                <div class="col-6">
                    <span>مانده حساب‌ها</span>
                </div>
                <div class="col-6">
                    <span> {{ $rest }} </span>
                    <small>تومان</small>
                </div>
            </div>
        </div>


        @foreach ($installments as $installment)
            <ul class="list-group list-group-horizontal list-group-installments mx-md-0 ">
                <li class=" list-group-item {{ $installment->status_class }}">
                    <span>{{ $loop->index + 1 }}</span>
                </li>
                <li class=" list-group-item {{ $installment->status_class }}">
                    <span>{{ $installment->amount_str }}</span>
                    @if ($installment->type == 'canceled')
                        <span class="badge bg-warning">کنسلی</span>
                    @endif
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
                    <a href="#receive-{{ $receive->id }}">{{ $receive->amount_str }}</a>
                </li>
                <li class=" list-group-item list-group-item-success ">
                    <span>{{ $receive->date }}</span>
                </li>
                <li class=" list-group-item list-group-item-success ">
                    <span>{{ $receive->type_str }}</span>
                </li>
            </ul>
        @endforeach
        <ul class="list-group list-group-horizontal list-group-receive-result mx-md-0" style="max-width: 364px">
            <li class=" list-group-item list-group-item-success w-50">
                <span>جمع‌کل</span>
            </li>
            <li class=" list-group-item list-group-item-success w-50">
                <span>
                    {{ number_format(collect($contractReceives)->sum('amount') - $contract->advance_payment) }}
                    <small>تومان</small>
                </span>
            </li>

        </ul>
        <ul class="list-group list-group-horizontal list-group-receive-result mx-md-0" style="max-width: 364px">
            <li class=" list-group-item list-group-item-success w-50">
                <span>جمع‌کل با پیش‌پرداخت</span>
            </li>
            <li class=" list-group-item list-group-item-success w-50">
                <span>
                    {{ number_format(collect($contractReceives)->sum('amount')) }}
                    <small>تومان</small>
                </span>
            </li>
        </ul>
    </div>
</div>
