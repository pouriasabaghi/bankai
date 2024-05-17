@extends('admin.master')

@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="plus-circle"></span>
            <span>ثبت پرداختی</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.payments.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
