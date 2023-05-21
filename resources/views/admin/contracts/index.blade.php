@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="users"></span>
            <span>مشتریان</span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.button.Button href="{{ route('contracts.create') }}" btn='success' class="mb-3">افزودن مشتری جدید</x-ui.button.Button>
            <x-ui.table.Table :attr="['id' => 'contracts-table']" :header="['#', 'نام', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($contracts as $contract)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="">
                                    {{ $contract->name }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <form method="post" action='{{ route('contracts.destroy', $contract->id) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button.Delete />
                                    </form>

                                    <x-ui.button.Edit href="{{ route('contracts.edit', $contract->id) }}" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            @foreach (range(1, 3) as $item)
                                <td>-</td>
                            @endforeach
                        </tr>
                    @endforelse
                </x-slot>
            </x-ui.table.Table>

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$contracts" />
        </x-slot>
    </x-ui.card.Card>
@endsection
