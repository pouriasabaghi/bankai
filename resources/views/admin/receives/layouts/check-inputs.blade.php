<x-ui.form.Input name="receives[{{ $loop->index }}][bank_name]" value="{{ $receive->bank_name ?? '' }}"
    label="نام بانک" col='2' />

<x-ui.form.Input name="receives[{{ $loop->index }}][branch_name]" value="{{ $receive->branch_name ?? '' }}"
    label="نام شعبه" col='2' />

<x-ui.form.Input name="receives[{{ $loop->index }}][branch_code]" value="{{ $receive->branch_code ?? '' }}"
    label="کد شعبه" col='2' />

<x-ui.form.Input name="receives[{{ $loop->index }}][serial_number]" value="{{ $receive->serial_number ?? '' }}"
    label="سریال چک" col='2' />

<x-ui.form.Datepicker name="receives[{{ $loop->index }}][received_at]" :attr="['tabindex' => '-1']"
    value="{{ $receive->received_at ?? '' }}" label="تاریخ دریافت چک" col='2' />

<x-ui.form.Datepicker name="receives[{{ $loop->index }}][due_at]" :attr="['tabindex' => '-1']"
    value="{{ $receive->due_at ?? '' }}" label="تاریخ سررسید چک" col='2' />

<x-ui.form.Input name="receives[{{ $loop->index }}][desc]" value="{{ $receive->desc ?? '' }}" label="توضیحات"
    col='10' />

<div class="col-md-2 d-flex ">
    <x-ui.form.InputCheckbox labelClass="mt-auto" name="receives[{{ $loop->index }}][passed]" value="true" checked="{{ $receive->passed ?? false }}" label="پاس شد؟"
        />
</div>
