@extends('admin.master')

@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="star"></span>
            <span>ویرایش خدمت</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.services.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
