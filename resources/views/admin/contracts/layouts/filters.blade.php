<x-ui.card.Card>
    <x-slot name="header">
        <span data-feather="filter"></span>
        <span>فیلترها:</span>
    </x-slot>

    <x-slot name="body">
        <x-ui.form.Form method="get" action="{{ route('contracts.index') }}">
            <div class="row align-items-center">
                <div class="col-9">
                    <x-ui.form.InputLayout>
                        <x-ui.form.Select name='filters[archived]' label="وضعیت قرارداد:" script='no'
                            class="form-control form-select">
                            <x-ui.form.Option selected="{{ request()->filters && request()->filters['archived'] == '' }}" value="">همه</x-ui.form.Option>
                            <x-ui.form.Option selected="{{ request()->filters && request()->filters['archived'] == 'false' }}" value="false">قراردادهای باز</x-ui.form.Option>
                            <x-ui.form.Option selected="{{ request()->filters && request()->filters['archived'] == 'true' }}" value="true">آرشیو شده</x-ui.form.Option>
                        </x-ui.form.Select>
                    </x-ui.form.InputLayout>
                </div>
                <div class="col-3 mt-3">
                    <x-ui.button.Button class="w-100" type='submit' >
                        اعمال
                    </x-ui.button.Button>
                </div>
            </div>
        </x-ui.form.Form>
    </x-slot>
</x-ui.card.Card>
