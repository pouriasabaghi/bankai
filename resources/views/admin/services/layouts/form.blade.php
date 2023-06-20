<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input value="{{ $service->name ?? '' }}" name='name' label='نام سرویس(خدمت)'
            :attr="['required' => 'required']" />
        @if (!$formAttributes['isUpdate'])
            <x-ui.form.InputCheckbox name='stay_in_page' label='ماندن در صفحه' value='true' />
        @endif
        <div class="col-12 mt-auto mb-3">
            <x-ui.button.Button >
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
