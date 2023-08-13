@extends('admin.master')

@section('content')
    @include('admin.contracts.layouts.top-from', ['id' => $contract->id])
    <x-ui.card.Card id='receives'>
        <x-slot name='header'>
            <span data-feather="download"></span>
            <span>مدیریت دریافتی‌ها</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.receives.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
