<x-ui.card.Card>
    <x-slot name="header">
        <span data-feather="filter"></span>
        <span>فیلترها:</span>
    </x-slot>

    <x-slot name="body">
        <x-ui.form.Form method="get" action="{{ route('contracts.index') }}">
            <div class="row align-items-end">
                <div class="col-9">
                    <x-ui.form.InputLayout>
                        <x-ui.form.Select name='filters[archived]' label="وضعیت قرارداد:" script='no'
                            class="form-control form-select">
                            <x-ui.form.Option
                                selected="{{ request()->filters && request()->filters['archived'] == '' }}"
                                value="">همه</x-ui.form.Option>
                            <x-ui.form.Option
                                selected="{{ request()->filters && request()->filters['archived'] == 'false' }}"
                                value="false">قراردادهای باز</x-ui.form.Option>
                            <x-ui.form.Option
                                selected="{{ request()->filters && request()->filters['archived'] == 'true' }}"
                                value="true">آرشیو شده</x-ui.form.Option>
                        </x-ui.form.Select>

                        @if (!empty(request()->filters['archived']) && request()->filters['archived'] == 'true')
                            <x-ui.form.Select name='filters[debtor]' label="وضعیت حساب‌ها:" script='no'
                                class="form-control form-select">
                                <x-ui.form.Option
                                    selected="{{ !empty(request()->filters['debtor']) && !empty(request()->filters['debtor']) == '' }}"
                                    value="">همه</x-ui.form.Option>
                                <x-ui.form.Option
                                    selected="{{ !empty(request()->filters['debtor']) && request()->filters['debtor'] == 'true' }}"
                                    value="true">بدهکار</x-ui.form.Option>
                            </x-ui.form.Select>
                        @endif
                    </x-ui.form.InputLayout>
                </div>
                <div class="col-3 mb-3">
                    <x-ui.button.Button class="w-100" type='submit'>
                        اعمال
                    </x-ui.button.Button>
                </div>

                @if ($totalDebtor)
                    <x-ui.alert.Alert alert='warning' icon='dollar'>
                        <p class="mb-0 fw-normal">
                            مطالبات در انتظار وصول
                            {{ $totalDebtor }}
                            <small>تومان</small>
                        </p>
                    </x-ui.alert.Alert>
                @endif
            </div>
        </x-ui.form.Form>
    </x-slot>
</x-ui.card.Card>
