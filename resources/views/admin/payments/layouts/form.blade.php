<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>


        <x-ui.form.Select class="form-control" name='from' col='6' label='از حساب'>
            @forelse ($cards as $card)
                <x-ui.form.Option
                    selected="{{ !empty($card->id) && !empty($payment->from) && $card->id == $payment->from }}"
                    value="{{ $card->id }}">{{ $card->name }}</x-ui.form.Option>
            @empty
                <x-ui.form.Option :disabled='true' value='null'>حساب وجود ندارد
                </x-ui.form.Option>
            @endforelse
        </x-ui.form.Select>


        <div class="col-md-6" dir="ltr">
            <label class="form-label d-block">به حساب</label>
            <div class="input-group">
                <div class="input-group-text mt-1">
                    <label class="form-checkbox-input d-flex align-items-center">
                        <input type="checkbox" class="ms-1" title="ذخیره در حساب‌ها" name="add_to_cards">
                        <small style="font-size: 10px">ذخیره در حساب‌ها</small>
                    </label>
                </div>

                <input list="cards-list" name="to" type="text" class="form-control mt-1 text-start "
                    placeholder="" autocomplete="off" value="{{ old('to', $payment->to ?? '') }}" style=""
                    title="به حساب" required oninvalid="this.setCustomValidity('این فیلد نمی‌تواند خالی باشد')"
                    oninput="setCustomValidity('')">
            </div>


            <datalist id="cards-list">
                @forelse ($cards as $card)
                    <option label="{{ $card->name }}" value="{{ $card->number }}"></option>
                @empty
                @endforelse
            </datalist>
        </div>

        <x-ui.form.Select class="form-control" name='cost' col='6' label='بابت'>
            @forelse ($costs as $cost)
                <x-ui.form.Option
                    selected="{{ !empty($cost->id) && !empty($payment->cost_id) && $cost->id == $payment->cost_id }}"
                    value="{{ $cost->id }}">{{ $cost->name }}</x-ui.form.Option>
            @empty
                <x-ui.form.Option :disabled='true' value='null'>دسته بندی وجود ندارد
                </x-ui.form.Option>
            @endforelse
        </x-ui.form.Select>


        <x-ui.form.Input name='amount' value="{{ old('amount', $payment->amount_str ?? '') }}" label='مبلغ'
            col='6' :attr="['data-separate' => 'true', 'required' => 'required']" />

        <x-ui.form.Input name='desc' value="{{ old('desc', $payment->desc ?? '') }}" label='توضیحات'
            col='12' />


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
