<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name='name' value="{{ old('name', $cost->name ?? '') }}" label='نام دسته' col='6'
            :attr="['required' => 'required']" />

        <x-ui.form.Input name='desc' value="{{ old('desc', $cost->desc ?? '') }}" label='توضیحات' col='6' />


        <div class="col-md-12">
            @if ($formAttributes['form'] == 'store')
                <x-ui.form.Stay />
            @endif

            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
