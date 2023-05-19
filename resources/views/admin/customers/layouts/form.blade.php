<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name='name' value='{{ old("name", $customer->name ?? "") }}' label='نام مشتری' col='6' :attr="['required'=>'required']"/>
        <x-ui.form.Input name='mobile' value='{{ old("mobile", $customer->mobile ?? "") }}' label='شماره موبایل' col='6' placeholder='شماره‌ها را با , از یک دیگر جدا کنید' />
        <x-ui.form.Input name='phone' value='{{ old("phone", $customer->phone ?? "") }}' label='شماره تلفن' col='6' placeholder='شماره‌ها را با , از یک دیگر جدا کنید' />
        <x-ui.form.Input name='desc' value='{{ old("desc", $customer->desc ?? "") }}' label='توضیحات' col='6' />
        <div class="col-md-6">
            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
