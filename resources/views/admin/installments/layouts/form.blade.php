@if (request()->has('step'))
    <x-ui.alert.Alert alert='info'>
        در صورت بازتولید اقساط موقتا نمایش اقساط به صورت تسویه نشده در ‌می‌آیند، پس از دخیره اقساط با تنظیمات
        جدید مجدد وضعیت تسویه اقساط محاسبه می‌شود.
    </x-ui.alert.Alert>
@endif

@if (request()->has('start') && !request()->filled('start'))
    <x-ui.alert.Alert alert='info'>
        در صورت خالی بودن فیلد تاریخ شروع اقساط، تاریخ شروع از زمان شروع قرارداد خواهد بود.
    </x-ui.alert.Alert>
@endif

@if (request()->has('count') && !request()->filled('count'))
    <x-ui.alert.Alert alert='info'>
        در صورت خالی بودن فیلد تعداد اقساط، اقساط بر اساس تعداد ماه های قرارداد محسابه می‌شود.
    </x-ui.alert.Alert>
@endif


@include('admin.installments.layouts.detail', [
    'total_price' => $contract->total_price,
    'total_price_str' => $contract->total_price_str,
    'installments_price' => $contract->installments_total_price,
    'installments_price_str' => $contract->installments_total_price_str,
    'advance_payment' => $contract->advance_payment_str,
    'period' => $contract->period,
    'payable'=>$contract->payable_str,
])


<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <div class="col-12">
            <div class="row manage-row__group">
                @foreach ($installments as $installment)
                    <div class="col-12 manage-row__items {{ $loop->index == 0 ? '' : 'mt-3' }}
                        {{ $loop->index < $installmentsCount || !empty($installment->created_at) ? '' : 'd-none' }}"
                        data-row-count="{{ $loop->index + 1 }}">
                        <div class="d-flex align-items-center mb-2">
                            <i role='button'
                                class="fa-solid fa-circle-xmark fa-lg align-items-center d-flex fa-solid  me-2
                                {{ $loop->index == 0 ? 'text-secondary' : 'text-danger manage-row__button_delete' }}">
                            </i>
                            <h6 class="mb-0">قسط شماره {{ $loop->index + 1 }}</h6>
                        </div>
                        <div class="row">
                            @if (!empty($installment->amount) && !request()->has('start'))
                                <x-ui.form.Input name="installment[{{ $loop->index }}][amount]"
                                    value="{{ $installment->amount_str }}" placeholder="مبلغ" :attr="['data-separate' => 'true']"
                                    col='2' />
                            @elseif (!empty($installmentsAmount))
                                <x-ui.form.Input name="installment[{{ $loop->index }}][amount]"
                                    value="{{ !empty($installmentsAmount[$loop->index]) ? number_format($installmentsAmount[$loop->index]) : '' }}"
                                    placeholder="مبلغ" :attr="['data-separate' => 'true']" col='2' />
                            @else
                                <x-ui.form.Input name="installment[{{ $loop->index }}][amount]" placeholder="مبلغ"
                                    :attr="['data-separate' => 'true']" col='2' />
                            @endif

                            <x-ui.form.Datepicker name="installment[{{ $loop->index }}][due_at]" :attr="['tabindex' => '-1']"
                                value="{{ $installment->due_at ??
                                    ($loop->index == 0
                                        ? jdate()->fromFormat('Y/m/d', $start)->format('Y/m/d')
                                        : jdate()->fromFormat('Y/m/d', $start)->addMonths($loop->index)->format('Y/m/d')) }}"
                                placeholder="تاریخ سر رسید قسط" col='2' />

                            <x-ui.form.Input name="installment[{{ $loop->index }}][desc]"
                                value="{{ $installment->desc ?? '' }}" placeholder="توضیحات" col='4' />

                            <x-ui.form.Select name="installment[{{ $loop->index }}][kind]"  script='no' col="2" class="form-select form-select-sm" >
                                <x-ui.form.Option selected="{{ !empty($installment->kind) && $installment->kind == 'deposit'  || !empty(request()['kind']) && request()['kind'] == 'deposit' }}" value="deposit">
                                    واریز
                                </x-ui.form.Option>
                                <x-ui.form.Option selected="{{ !empty($installment->kind) && $installment->kind == 'check'  || !empty(request()['kind']) && request()['kind'] == 'check' }}" value="check">
                                    چک
                                </x-ui.form.Option>

                            </x-ui.form.Select>

                            <div class="col-md-2">
                                <span
                                    class="{{ \App\Enums\InstallmentStatusEnum::tryFrom($installment->status ?? 'billed')->statusColor() }}">
                                    {{ \App\Enums\InstallmentStatusEnum::tryFrom($installment->status ?? 'billed')->toString() }}
                                </span>
                                <x-ui.form.InputCheckbox labelClass="d-none"
                                    name='installment[{{ $loop->index }}][status]' label='تسویه شده؟' value='paid'
                                    checked="{{ !empty($installment->status) && $installment->status == 'paid' ? true : false }}" />
                            </div>

                            <input name="installment[{{ $loop->index }}][type]" value="planned" type='hidden' />

                        </div>
                    </div>
                @endforeach
                <div class="col-12 text-end mt-3">
                    <x-ui.button.Button type='button' class="btn-sm manage-row__button" btn='success'>
                        افزودن
                    </x-ui.button.Button>
                </div>
            </div>

            <hr>

            <x-ui.collapse.Collapse parentClass="mb-3" id='canceled' :show="$contractStatus">
                <div class="d-flex" style="max-width:max-content">
                    <i class="fa-solid fa-ban me-2 text-danger"></i>

                    <x-ui.form.InputCheckbox name='contract_status' label='قرارداد کنسل شده؟' value='canceled'
                        checked="{{ $contractStatus }}" :nomargin="true" />
                </div>

                <x-slot name='content'>
                    <div class="col-12  mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <h6 class="mb-0">مبلغ کنسلی قرارداد</h6>
                        </div>
                        <div class="row">
                            @if (!empty($canceled->amount))
                                <x-ui.form.Input name="canceled[amount]" value="{{ $canceled->amount_str }}"
                                    placeholder="مبلغ" :attr="['data-separate' => 'true']" col='2' />
                            @else
                                <x-ui.form.Input name="canceled[amount]" placeholder="مبلغ" :attr="['data-separate' => 'true']"
                                    col='2' />
                            @endif

                            <x-ui.form.Datepicker name="canceled[due_at]" :attr="['tabindex' => '-1']"
                                value="{{ $canceled->due_at ?? '' }}" placeholder="تاریخ سر رسید قسط" col='2' />

                            <x-ui.form.Input name="canceled[desc]" value="{{ $canceled->desc ?? '' }}"
                                placeholder="توضیحات" col='6' />

                            <div class="col-md-2">
                                <x-ui.form.InputCheckbox labelClass="d-none" name='canceled[status]' label='تسویه شده؟'
                                    value='paid'
                                    checked="{{ !empty($canceled->status) && $canceled->status == 'paid' ? true : false }}" />
                            </div>

                            <x-ui.form.Input name="canceled[type]" value="canceled" type='hidden' />

                        </div>
                    </div>
                </x-slot>
            </x-ui.collapse.Collapse>
        </div>
        <div class="col-md-6">

            <x-ui.button.Button class="submit-form">
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
