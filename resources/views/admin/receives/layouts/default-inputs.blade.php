<x-ui.form.Input name="receives[{{ $loop->index }}][amount]" value="{{ $receive->amount ?? '' }}" label="مبلغ"
    col='4' />

<x-ui.form.Select class="form-control" name='card_id' col='4' label='حساب'>
    @forelse ($cards as $card)
        <x-ui.form.Option selected="{{ !empty($card->id) && $card->id == $contract->card_id }}"
            value="{{ $card->id }}">{{ $card->name }}</x-ui.form.Option>
    @empty
        <x-ui.form.Option :disabled='true' value='null'>حساب وجود ندارد
        </x-ui.form.Option>
    @endforelse
</x-ui.form.Select>

<x-ui.form.Select class="form-control" name='customer_id' col='4' label='مجموعه‌'>
    @forelse ($companies as $company)
        <x-ui.form.Option selected="{{ !empty($company->company->id) && $company->id == $company->company->id }}"
            value="{{ $company->id }}">{{ $company->name }}</x-ui.form.Option>
    @empty
        <x-ui.form.Option :disabled='true' value='null'>مجموعه وجود ندارد
        </x-ui.form.Option>
    @endforelse
</x-ui.form.Select>

{{-- Fisrt default value is check but this will be change with js when user change type and click on add more  --}}
<input class="receive-type" type='hidden' name="receives[{{ $loop->index }}][type]" value="check" />
