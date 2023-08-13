@extends('admin.master')

@section('content')
    @include('admin.contracts.layouts.top-from', ['id'=>$contract->id ])
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="edit-3"></span>
            <span>ویرایش قرارداد</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.contracts.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
