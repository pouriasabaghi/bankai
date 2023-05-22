@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="credit-card"></span>
            <span>حساب ها</span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.button.Button href="{{ route('cards.create') }}" btn='success' class="mb-3">افزودن حساب جدید</x-ui.button.Button>
            <x-ui.table.Table :attr="['id' => 'card-table']" :header="['#', 'نام', 'شماره‌حساب','موجودی' ,'اقدامات']">
                <x-slot name="tbody">
                    @forelse($cards as $card)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="">
                                    {{ $card->name }}
                                </a>
                            </td>
                            <td>{{ $card->number}}</td>
                            <td>{{ $card->amountStr }}</td>
                            <td>
                                <div class="d-flex">
                                    <form method="post" action='{{ route('cards.destroy', $card->id) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button.Delete />
                                    </form>

                                    <x-ui.button.Edit href="{{ route('cards.edit', $card->id) }}" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            @foreach (range(1, 5) as $item)
                                <td>-</td>
                            @endforeach
                        </tr>
                    @endforelse
                </x-slot>
            </x-ui.table.Table>

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$cards" />
        </x-slot>
    </x-ui.card.Card>
@endsection
