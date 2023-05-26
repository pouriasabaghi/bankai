<x-ui.form.Input name="receives[{{ $loop->index }}][amount]" value="{{ $receive->amountStr ?? '' }}" label="مبلغ" col='6'
    :attr="['data-separate' => 'true']" />

<x-ui.form.Select class="form-control" name='receives[{{ $loop->index }}][card_id]' col='6' label='حساب'>
    @forelse ($cards as $card)
        <x-ui.form.Option selected="{{ !empty($card->id) && !empty($receive->card_id) && $card->id == $receive->card_id  }}"
            value="{{ $card->id }}">{{ $card->name }}</x-ui.form.Option>
    @empty
        <x-ui.form.Option :disabled='true' value='null'>حساب وجود ندارد
        </x-ui.form.Option>
    @endforelse
</x-ui.form.Select>


{{-- Fisrt default value is check but this will be change with js when user change type and click on add more  --}}
<input class="receive-type" type='hidden' name="receives[{{ $loop->index }}][type]" value="{{ $receive->type ?? 'check' }}" />
<input type='hidden' name="receives[{{ $loop->index }}][customer_id]" value="{{ $contract->customer->id }}" />
<input type='hidden' name="receives[{{ $loop->index }}][company_id]" value="{{ $contract->company->id }}" />
<input type='hidden' name="receives[{{ $loop->index }}][contract_id]" value="{{ $contract->id }}" />
