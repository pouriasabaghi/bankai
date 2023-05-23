<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <div class="col-12">
            <div class="row manage-row__group">
                @foreach ($installments as $installment)
                    <div class="col-12 manage-row__items {{ $loop->index == 0 ? '' : 'mt-3' }}
                        {{ $loop->index < $installmentCount || !empty($deposit->created_at) ? '' : 'd-none' }}"
                        data-row-count="{{ $loop->index + 1 }}">
                        <div class="d-flex align-items-center mb-2">
                            @if ($loop->index > -1)
                                <i role='button'
                                    class="fa-solid fa-circle-xmark fa-lg align-items-center d-flex fa-solid  me-2 text-danger manage-row__button_delete"></i>
                            @endif
                            <h6 class="mb-0">قسط شماره {{ $loop->index + 1 }}</h6>
                        </div>
                        <div class="row">
                            @if (!empty($installment->amount))
                                <x-ui.form.Input name="installment[{{ $loop->index }}][amount]"
                                    value="{{ $installment->amount }}" placeholder="مبلغ" :attr="['data-separate' => 'true']"
                                    col='4' />
                            @else
                                <x-ui.form.Input name="installment[{{ $loop->index }}][amount]"
                                    value="{{ !empty($ins[$loop->index]) ? number_format($ins[$loop->index]) : '' }}" placeholder="مبلغ" :attr="['data-separate' => 'true']"
                                    col='4' />
                            @endif

                            <x-ui.form.DatePicker name="installment[{{ $loop->index }}][due_at]" :attr="['tabindex' => '-1']"
                                value="{{ $installment->due_at ??jdate()->fromFormat('Y/m/d', $contract->signed_at)->addMonths($loop->index + 1)->format('Y/m/d') }}"
                                placeholder="تاریخ سر رسید قسط" col='4' />

                            <x-ui.form.Input name="installment[{{ $loop->index }}][desc]"
                                value="{{ $installment->amount ?? '' }}" placeholder="توضیحات" col='4' />

                        </div>
                    </div>
                @endforeach
                <div class="col-12 text-end mt-3">
                    <x-ui.button.Button type='button' class="btn-sm manage-row__button" btn='success'>
                        افزودن
                    </x-ui.button.Button>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
