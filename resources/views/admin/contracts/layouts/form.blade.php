<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name="name" value="{{ old('name', $contract->name ?? '') }}" label="عنوان قرارداد" />

        {{-- List of customers and companies  --}}
        <div class="col-md-12">
            <livewire:customer-and-company />
        </div>

        {{-- Types --}}
        <x-ui.form.Select class="form-control" name='type' col='6' label='دسته‌بندی خدمات'>
            @forelse ($types as $type)
                @if ($formAttributes['isUpdate'])
                    {{-- maybe contarct type has been deleted and no select match. this stand for default value and edit value  --}}
                    @if ($contract->type)
                        <x-ui.form.Option value="{{ $contract->type }}">{{ $contract->type }}</x-ui.form.Option>
                    @endif

                    {{-- remove duplicate option from previous default --}}
                    @if ($contract->type != $type->name)
                        <x-ui.form.Option value="{{ $type->name }}">{{ $type->name }}</x-ui.form.Option>
                    @endif
                @else
                    <x-ui.form.Option value="{{ $type->name }}">{{ $type->name }}</x-ui.form.Option>
                @endif
            @empty
                <x-ui.form.Option :disabled='true' value='null'>دسته‌بندی یافت نشد</x-ui.form.Option>
            @endforelse
        </x-ui.form.Select>

        {{-- Services --}}
        <div class="col-md-6">
            <livewire:select-or-create-service />
        </div>

        {{-- Contract number --}}
        <x-ui.form.Input col='6' label='شماره قرارداد' name='contract_number' />

        {{-- Signed_at --}}
        <x-ui.form.Datepicker col='6' value="{{ $contract->signed_at ?? '' }}" name='signed_at'
            label='تاریخ امضای قرارداد' />

        {{-- Periods --}}
        <x-ui.form.Input :attr="['list'=>'periods-list']" label='بازه زمانی' name='period' col='6'>
            <x-slot name='datalist'>
                <datalist id="periods-list">
                    <option label="فصلی" value="3 ماهه"></option>
                    <option label="نیم ساله" value="6 ماهه"></option>
                    <option label="سالانه" value="12 ماهه"></option>
                </datalist>
            </x-slot>
        </x-ui.form.Input>
        <x-ui.form.Input  label='مبلغ کل قرارداد' name='total_price' col='6' :attr="['data-separate'=>'true']" />
        <x-ui.form.Input  label='توضیحات' name='desc' col='12' />

        <div class="col-md-12">
            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
