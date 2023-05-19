<x-ui.form.Form method="post" action="{{ route('services.store') }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name='name' label='نام سرویس(خدمت)' col='8 col-8' :attr="['required' => 'required']" />
        <div class="col-4 mt-auto mb-3">
            <x-ui.button.Button >
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
