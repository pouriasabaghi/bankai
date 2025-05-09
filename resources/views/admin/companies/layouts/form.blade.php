<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name='name' value="{{ old('name', $company->name ?? '') }}" label='نام مجموعه' col='6'
            :attr="['required' => 'required']" />
        <x-ui.form.Select multiple='true' class="form-control" name='customers[]' col='6' label='مشتری'>
            @forelse ($customers as $customer)
                <x-ui.form.Option
                    selected="{{ !empty($company->customers) && in_array($customer->id, $company->customers->pluck('id')->toArray()) }}"
                    value="{{ $customer->id }}">{{ $customer->name }}</x-ui.form.Option>
            @empty
                <x-ui.form.Option :disabled='true' value='null'>مشتری وجود ندارد</x-ui.form.Option>
            @endforelse
        </x-ui.form.Select>

        <div class="col-md-6">
            @if ($formAttributes['form'] == 'store')
                <x-ui.form.InputCheckbox name='stay_in_page' label='ماندن در صفحه' value='true' />
            @endif

            @if (auth()->user()->role != 'user')
                <x-ui.button.Button>
                    ذخیره
                </x-ui.button.Button>
            @endif
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
