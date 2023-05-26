<x-ui.form.Input name="receives[{{ $loop->index }}][bank_name]" value="{{ $receive->bank_name ?? '' }}"
    placeholder="نام بانک" col='2' />

<x-ui.form.Input name="receives[{{ $loop->index }}][branch_name]" value="{{ $receive->branch_name ?? '' }}"
    placeholder="نام شعبه" col='2' />

<x-ui.form.Input name="receives[{{ $loop->index }}][branch_code]" value="{{ $receive->branch_code ?? '' }}"
    placeholder="کد شعبه" col='2' />

<x-ui.form.Input name="receives[{{ $loop->index }}][serial_number]" value="{{ $receive->serial_number ?? '' }}"
    placeholder="سریال چک" col='2' />

<x-ui.form.DatePicker name="receives[{{ $loop->index }}][received_at]" :attr="['tabindex' => '-1']"
    value="{{ $receive->received_at ?? '' }}" placeholder="تاریخ دریافت چک" col='2' />

<x-ui.form.DatePicker name="receives[{{ $loop->index }}][due_at]" :attr="['tabindex' => '-1']"
    value="{{ $receive->due_at ?? '' }}" placeholder="تاریخ سررسید چک" col='2' />
<x-ui.form.Input name="receives[{{ $loop->index }}][desc]" value="{{ $receive->desc ?? '' }}" placeholder="توضیحات"
    col='12' />


