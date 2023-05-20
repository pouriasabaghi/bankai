@extends('admin.master')

@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="edit-3"></span>
            <span>ویراش</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.cards.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
