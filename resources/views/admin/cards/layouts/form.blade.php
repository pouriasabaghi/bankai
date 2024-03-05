<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name='name' value="{{ old('name', $card->name ?? '') }}" label='نام حساب' col='6'
            :attr="['required' => 'required']" />

        <x-ui.form.Input name='number' value="{{ old('number', $card->number ?? '') }}" label='شماره حساب' col='6'
            :attr="['required' => 'required']" type='number' />

        <x-ui.form.Input name='amount' value="{{ old('amount', $card->amountStr ?? '') }}" label='موجودی'
            col='6' type='tel' :attr="['data-separate' => 'true']" :readonly="in_array(auth()->user()->role, ['manager', 'developer']) ? false : true" />


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
