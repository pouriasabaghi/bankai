<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name="name" value="{{ old('name', $contract->name ?? '') }}" label="عنوان قرارداد"
            :attr="['required' => 'required']" col='10' />

        {{-- Contract number --}}
        <x-ui.form.Input col='2' label='شماره قرارداد' name='contract_number'
            value="{{ $contract->contract_number ?? '' }}" />

        {{-- List of customers and companies  --}}
        <div class="col-md-12">
            <livewire:customer-and-company contractCompanyId="{{ $contract->company_id ?? 0 }}"
                contractCustomerId="{{ $contract->customer_id ?? 0 }}" />
        </div>

        {{-- Types --}}
        <x-ui.form.Select class="form-control" name='type' col='6' label='دسته‌بندی خدمات'>
            {{-- maybe contarct type has been deleted and no select match. this stand for default value and edit value.
                 even cause there is no relationship between contract and type can't directly
                 select previous value of contract type in edit page
                --}}
            @if ($formAttributes['isUpdate'])
                @if ($contract->type)
                    <x-ui.form.Option value="{{ $contract->type }}">{{ $contract->type }}</x-ui.form.Option>
                @endif
            @endif
            @forelse ($types as $type)
                {{-- remove duplicate option from previous default --}}
                @if ($formAttributes['isUpdate'])
                    @if ($contract->type != $type->name)
                        <x-ui.form.Option value="{{ $type->name }}"> {{ $type->name }}</x-ui.form.Option>
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
            <livewire:select-or-create-service :selectedServices="$contractServices" />
        </div>



        {{-- Total_price --}}
        <x-ui.form.Input label='مبلغ کل قرارداد' name='total_price' col='8' :attr="['data-separate' => 'true']"
            value="{{ $contract->total_price ?? '' }}" />

        {{-- Periods --}}
        <x-ui.form.Input :attr="['list' => 'periods-list']" label='بازه زمانی' name='period' col='4'
            value="{{ $contract->period ?? '' }}">
            <x-slot name='datalist'>
                <datalist id="periods-list">
                    <option label="فصلی" value="3 ماهه"></option>
                    <option label="نیم ساله" value="6 ماهه"></option>
                    <option label="سالانه" value="12 ماهه"></option>
                </datalist>
            </x-slot>
        </x-ui.form.Input>

        {{-- Signed_at --}}
        <x-ui.form.Datepicker col='6' value="{{ $contract->signed_at ?? '' }}" name='signed_at'
            label='تاریخ امضای قرارداد' />

        {{-- Canceled_at --}}
        @if ($formAttributes['isUpdate'])
            <x-ui.form.Datepicker col='6' value="{{ $contract->canceled_at }}" name='canceled_at'
                label='تاریخ لغو قرارداد' />
        @endif

        <x-ui.form.Input label='توضیحات' name='desc' col=' col' value="{{ $contract->desc ?? '' }}" />


        <div class="col-md-12">
            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
