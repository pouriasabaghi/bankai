@extends('admin.master')

@section('content')
    <x-ui.card.Card id='receives'>
        <x-slot name='header'>
            <i class="fa-solid fa-calendar"></i>
            <span>انتخاب تاریخ</span>
        </x-slot>
        <x-slot name='body'>
            <x-ui.form.Form method="get" action="{{ $action }}">
                <x-ui.form.InputLayout>
                    <x-ui.form.Datepicker col='6' value="{{ old('start', $contract->start ?? '') }}" name='start'
                        label='از تاریخ' :attr="['required' => 'true']" />
                    <x-ui.form.Datepicker col='6' value="{{ old('end', $contract->end ?? '') }}" name='end'
                        label='تا تاریخ' :attr="['required' => 'true']" />

                        <input type="hidden" name="directory" value="{{ request()->directory }}" />
                    <div class="col-md-12">
                        <x-ui.button.Button>
                            گزارش‌ گیری
                        </x-ui.button.Button>
                    </div>
                </x-ui.form.InputLayout>
            </x-ui.form.Form>
        </x-slot>
    </x-ui.card.Card>
@endsection
