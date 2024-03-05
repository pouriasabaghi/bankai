<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name="name" value="{{ old('name', $contract->name ?? '') }}" label="عنوان قرارداد"
            :attr="['required' => 'required']" col='10' />

        {{-- Contract number --}}
        <x-ui.form.Input col='2' label='شماره قرارداد' name='contract_number'
            value="{{ old('contract_number', $contract->contract_number ?? '') }}" />

        {{-- List of customers and companies  --}}
        <div class="col-md-12">
            <livewire:customer-and-company contractCompanyId="{{ old('company_id', $contract->company_id ?? 0) }}"
                contractCustomerId="{{ old('customer_id', $contract->customer_id ?? 0) }}" />
        </div>

        {{-- Types --}}
        <x-ui.form.Select class="form-control" name='type' col='6' label='دسته‌بندی خدمات'>
            {{-- maybe contarct type has been deleted and no select match. this stand for default value and edit value.
                 even cause there is no relationship between contract and type can't directly
                 select previous value of contract type in edit page
                --}}
            @if ($formAttributes['isUpdate'])
                @if ($contract->type)
                    <x-ui.form.Option
                        value="{{ old('type', $contract->type) }}">{{ $contract->type }}</x-ui.form.Option>
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
        <x-ui.form.Input label='مبلغ کل قرارداد' name='total_price' col='4' :attr="['data-separate' => 'true', 'required' => 'true']"
            value="{{ old('totla_price', $contract->total_price_str ?? '') }}" />


        {{-- Total_price --}}
        <x-ui.form.Input label='مبلغ بیعانه(می‌تواند خالی باشد)' name='advance_payment' col='3' :attr="['data-separate' => 'true']"
            value="{{ old('advance_payment', $contract->advance_payment_str ?? '') }}" />

        <x-ui.form.Select class="form-control" name='card_id' col='3' label='حساب مقصد بیعانه'>
            @forelse ($cards as $card)
                <x-ui.form.Option
                    selected="{{ !empty($advancePaymentReceive) && $advancePaymentReceive->card_id == $card->id }}"
                    value="{{ $card->id }}">{{ $card->name }}</x-ui.form.Option>
            @empty
                <x-ui.form.Option :disabled='true' value='null'>حساب وجود ندارد
                </x-ui.form.Option>
            @endforelse
        </x-ui.form.Select>

        {{-- Periods --}}
        <x-ui.form.Input :attr="['list' => 'periods-list']" label='بازه زمانی' name='period' col='2'
            value="{{ old('period', $contract->period ?? '') }}">
            <x-slot name='datalist'>
                <datalist id="periods-list">
                    <option label="ماهانه" value="1 ماهه"></option>
                    <option label="فصلی" value="3 ماهه"></option>
                    <option label="نیم ساله" value="6 ماهه"></option>
                    <option label="سالانه" value="12 ماهه"></option>
                </datalist>
            </x-slot>
        </x-ui.form.Input>

        {{-- Signed_at --}}
        <x-ui.form.Datepicker col='6' value="{{ old('signed_at', $contract->signed_at ?? '') }}"
            name='signed_at' label='تاریخ امضای قرارداد' :attr="['required' => 'true']" />

        {{-- Start_at --}}
        <x-ui.form.Datepicker col='6' value="{{ old('started_at', $contract->started_at ?? '') }}"
            name='started_at' label='تاریخ شروع قرارداد' :attr="['required' => 'true']" />

        {{-- Expired_at --}}
        @if ($formAttributes['isUpdate'])
            <x-ui.form.Datepicker col='6' value="{{ old('expired_at', $contract->expired_at ?? '') }}"
                name='expired_at' label='تاریخ پایان قرارداد' />
        @endif

        {{-- Canceled_at --}}
        @if ($formAttributes['isUpdate'])
            <x-ui.form.Datepicker col='6' value="{{ old('canceled_at', $contract->canceled_at ?? '') }}"
                name='canceled_at' label='تاریخ لغو قرارداد' />
        @endif

        <x-ui.form.Input label='توضیحات' name='desc' col=' col'
            value="{{ old('desc', $contract->desc ?? '') }}" />

        @if (auth()->user()->role != 'user')
            <div class="col-md-12">
                <x-ui.button.Button>
                    ذخیره
                </x-ui.button.Button>
            </div>
        @endif
    </x-ui.form.InputLayout>
</x-ui.form.Form>
