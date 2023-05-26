<x-ui.form.Input name="receives[{{ $loop->index }}][origin]"
    value="{{ $receive->origin ?? '' }}" label="رسید پرداخت و توضیحات" col='6' />

<x-ui.form.Datepicker name="receives[{{ $loop->index }}][paid_at]"
    value="{{ $receive->paid_at ?? '' }}" label="تاریخ پرداخت" col='6' />


