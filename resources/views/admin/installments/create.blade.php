@extends('admin.master')

@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="book"></span>
            <span>مدیریت اقساط</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.installments.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
