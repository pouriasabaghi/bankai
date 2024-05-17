@extends('admin.master')

@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="edit-3"></span>
            <span>
                ویرایش
                {{ $cost->name }}
            </span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.costs.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
