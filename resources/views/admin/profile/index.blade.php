@extends('admin.master')


@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="users"></span>
            <span>پروفایل</span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.form.Form method="put" action="{{ route('profile-admin.update', auth()->user()->id) }}">
                <x-ui.form.InputLayout>
                    <x-ui.form.Input name="username" value="{{ auth()->user()->name }}" label="نام کاربری" col='4'
                        type="text" />

                    <x-ui.form.Input name="" value="{{ auth()->user()->email }}" label="ایمیل" col='4'
                        type="text" :disabled="true" />

                    <x-ui.form.Input name="pagination" value="{{ get_user_pagination() }}"
                        label="تعداد موردها در هر برگه <small>(گام‌های ۵۰ تایی)</small>" :attr="['required' => 'required']" col='4'
                        type="number" :attr="['step' => '50', 'min' => '50']" />



                    <div class="col-md-12">
                        <x-ui.button.Button>
                            ذخیره
                        </x-ui.button.Button>
                    </div>
                </x-ui.form.InputLayout>
            </x-ui.form.Form>

        </x-slot>
    </x-ui.card.Card>
@endsection
