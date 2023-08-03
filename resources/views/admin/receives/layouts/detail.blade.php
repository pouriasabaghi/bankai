{{-- Showing detail total_price, priods and sum current installments --}}

<div class="row mb-3">
    <div class="col-md-6 col-xl-9 mb-3 mb-md-0 d-flex flex-column">
        <h6>
            <i class="fa-solid fa-circle-info fa-lg"></i>
            {{ $contract->name }}
        </h6>
        <div class="row mx-0">
            <div class="col-12 py-2 d-flex flex-column  bg-light receives-contract-information">
                <div class="row" style="font-size: 13px">
                    <div class="col-6 col-xl-3 mb-3 border-2 border-end pe-2">
                        <i class="fa-solid fa-file-signature"></i>
                        امضای قرارداد
                    </div>
                    <div class="col-6 col-xl-3 mb-3 ">{{ $contract->signed_at }}</div>


                    <div class="col-6 col-xl-3 mb-3 border-2 border-end pe-2">
                        <i class="fa-regular fa-handshake"></i>
                        شروع قرارداد
                    </div>
                    <div class="col-6 col-xl-3 mb-3 ">{{ $contract->started_at }}</div>

                    @if ($contract->canceled_at)
                        <div class="col-6 col-xl-3 mb-3 border-2 border-end pe-2">
                            <i class="fa-solid fa-power-off"></i>
                            لغو قرارداد
                        </div>
                        <div class="col-6 col-xl-3 mb-3 ">{{ $contract->canceled_at }}</div>
                    @endif


                    <div class="col-6 col-xl-3 mb-3 border-2 border-end pe-2 ">
                        <i class="fa-solid fa-user-tie"></i>
                        مشتری:
                    </div>
                    <div class="col-6 col-xl-3 mb-3 ">{{ $contract->customer->name }}</div>


                    <div class="col-6 col-xl-3 mb-3 border-2 border-end pe-2">
                        <i class="fa-solid fa-building-columns"></i>
                        مجموعه:
                    </div>
                    <div class="col-6 col-xl-3 mb-3 ">{{ $contract->company->name }}</div>


                    <div class="col-6 col-xl-3 mb-3 border-2 border-end pe-2">
                        <i class="fa-regular fa-star"></i>
                        دسته بندی خدمات:
                    </div>
                    <div class="col-6 col-xl-3 mb-3 ">{{ $contract->type }}</div>


                    <div class="col-6 col-xl-3 mb-3 border-2 border-end pe-2">
                        <i class="fa-regular fa-star"></i>
                        خدمات
                    </div>
                    <div class="col-6 col-xl-3 mb-3 ">{{ $contract->services->pluck('name')->implode(', ') }}</div>

                    <div class="col-6 col-xl-3 border-2 border-end pe-2">
                        <i class="fa-regular fa-calendar"></i>
                        مدت قرارداد
                    </div>
                    <div class="col-6 col-xl-3 ">{{ $contract->period }}</div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-xl-3 border-2 border-end pe-2">
                                <i class="fa-book-open fa-regular"></i>
                                توضیحات
                            </div>
                            <div class="col-6 col-xl-9 ">{{ $contract->desc }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-3 mb-md-0  d-flex flex-column">
        <h6>
            <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
            ترازمالی
        </h6>

        <div class="row mx-0 p-2 bg-light " style="font-size: 13px">
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

            <div class="row mx-0 px-0 border-2 border-bottom py-3 ">
                <div class="col-6">
                    <span>بیعانه:</span>
                </div>
                <div class="col-6">
                    <span> {{ $contract->advance_payment_str }} </span>
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




    </div>

    <div class="col-12 my-5 my-md-4">
        <h3>اقساط</h3>
        <x-ui.table.Table :header="['#', 'مبلغ', 'تاریخ‌سررسید', 'نوع‌پرداخت', 'توضیحات']">
            <x-slot name="tbody">
                @foreach ($installments as $installment)
                    <tr>
                        <td>
                            {{ $loop->index + 1 }}
                        </td>

                        <td class="{{ $installment->status_class }}">
                            {{ $installment->amount_str }}
                            @if ($installment->type == 'canceled')
                                <span class="badge bg-warning">کنسلی</span>
                            @endif
                            <small>تومان</small>
                        </td>

                        <td class="{{ $installment->status_date_class }}">
                            {{ $installment->due_at }}
                        </td>

                        <td>
                            {{ \App\Enums\InstallmentKindEnum::tryFrom($installment->kind)->toString() }}
                        </td>

                        <td>{{ $installment->desc }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-ui.table.Table>
    </div>

    <div class="col-12 my-5 mt-md-4 mb-md-5">
        <h3>شرح دریافتی‌ها</h3>
        <x-ui.table.Table :header="['#', 'مبلغ', 'تاریخ‌دریافت', 'نوع‌پرداخت', 'به حسابه']">
            <x-slot name="tbody">
                @foreach ($contractReceives as $receive)
                    <tr>
                        <td>
                            <span>{{ $loop->index + 1 }}</span>
                        </td>
                        <td>
                            <a href="#receive-{{ $receive->id }}">{{ $receive->amount_str }}</a>
                        </td>
                        <td>
                            <span>{{ $receive->date }}</span>
                        </td>
                        <td>
                            <span>{{ $receive->type_str }}</span>
                        </td>
                        <td>
                            {{ $receive->card->name }}
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-ui.table.Table>
    </div>

</div>
