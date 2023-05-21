@extends('admin.master')

@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="file-plus"></span>
            <span>افزودن قرارداد</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.contracts.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
