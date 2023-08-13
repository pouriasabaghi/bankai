@extends('admin.master')

@section('content')
    @include('admin.contracts.layouts.top-from', ['id' => $contract->id])
    <x-ui.card.Card id="installments">
        <x-slot name='header'>
            <span data-feather="book"></span>
            <span>مدیریت اقساط</span>
            <div class="col-xl-2 ms-auto mt-3 mt-lg-0">
                @include('admin.installments.layouts.installments-settings')
            </div>
        </x-slot>
        <x-slot name='body'>
            @include('admin.installments.layouts.form')
        </x-slot>
    </x-ui.card.Card>
@endsection
