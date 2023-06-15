<form class="d-flex flex-column" method="get">
    <x-ui.form.Datepicker class="form-control-sm" name='start' value="{{ request()->start }}"
        placeholder='تاریخ شروع اقساط' />

    <x-ui.form.Input name='count' class="form-control-sm" type='number' placeholder='تعداد اقساط'
        value="{{ request()['count'] }}" />

    <x-ui.form.Select name='step' class="form-select form-select-sm" script='no'>
        <x-ui.form.Option selected="{{ request()['step'] == '10000' ? true : false }}" value='10000'>اقساط مساوی
        </x-ui.form.Option>
        <x-ui.form.Option selected="{{ request()['step'] == '100000' ? true : false }}" value='100000'>با دقت 100
            هزارتومان</x-ui.form.Option>
        <x-ui.form.Option selected="{{ request()['step'] == '500000' ? true : false }}" value='500000'>با دقت 500
            هزارتومان</x-ui.form.Option>
        <x-ui.form.Option selected="{{ request()['step'] == '1000000' ? true : false }}" value='1000000'>با دقت 1 میلیون
            تومان</x-ui.form.Option>
        <x-ui.form.Option selected="{{ request()['step'] == '5000000' ? true : false }}" value='5000000'>با دقت 5 میلیون
            تومان</x-ui.form.Option>
    </x-ui.form.Select>


    <x-ui.button.Button class="btn-sm">اعمال</x-ui.button.Button>

    @if (request()->hasAny(['start', 'count', 'step']))
        <x-ui.button.Button class="btn-sm mt-1" btn='danger' href="{{ url()->current() }}">حذف فیلترها
        </x-ui.button.Button>
    @endif

</form>
