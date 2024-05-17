@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="shopping-bag"></span>
            <span>هزینه‌ها</span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.button.Button href="{{ route('costs.create') }}" btn='success' class="mb-3">افزودن دسته جدید
            </x-ui.button.Button>
            <x-ui.table.Table :attr="['id' => 'costs-table']" :header="['#', 'عنوان', 'توضیحات', 'هزینه‌تا‌به‌الان', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($costs as $cost)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="#">
                                    {{ $cost->name }}
                                </a>
                            </td>
                            <td>{{ $cost->desc }}</td>
                            <td>-</td>
                            <td>
                                <div class="d-flex">
                                    <form method="post" action='{{ route('costs.destroy', $cost->id) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button.Delete />
                                    </form>

                                    <x-ui.button.Edit href="{{ route('costs.edit', $cost->id) }}" />
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

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$costs" />
        </x-slot>
    </x-ui.card.Card>
@endsection
