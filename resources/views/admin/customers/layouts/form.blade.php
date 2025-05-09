<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name='name' value="{{ old('name', $customer->name ?? '') }}" label='نام مشتری' col='6'
            :attr="['required' => 'required']" />
        <x-ui.form.Input name='mobile' value="{{ old('mobile', $customer->mobile ?? '') }}" label='شماره موبایل'
            col='6' placeholder='شماره‌ها را با - از یک دیگر جدا کنید' />
        <x-ui.form.Input name='phone' value="{{ old('phone', $customer->phone ?? '') }}" label='شماره تلفن'
            col='6' placeholder='شماره‌ها را با - از یک دیگر جدا کنید' />
        <x-ui.form.Input name='desc' value="{{ old('desc', $customer->desc ?? '') }}" label='توضیحات'
            col='6' />
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
