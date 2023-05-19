<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name='name' value="{{ old('name', $company->name ?? '') }}" label='نام مجموعه' col='6'
            :attr="['required' => 'required']" />
        <x-ui.form.Select class="form-control" name='customer_id' col='6' label='مشتری'>
            @forelse ($customers as $customer)
                <x-ui.form.Option value="{{ $customer->id }}">{{ $customer->name }}</x-ui.form.Option>
            @empty
                <x-ui.form.Option :disabled='true' value='null'>مشتری وجود ندارد</x-ui.form.Option>
            @endforelse
        </x-ui.form.Select>

        <div class="col-md-6">
            @if ($formAttributes['form'] == 'store')
                <x-ui.form.InputCheckbox name='stay_in_page' label='ماندن در صفحه' value='true' />
            @endif
            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
