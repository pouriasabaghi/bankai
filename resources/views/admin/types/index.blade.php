@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="star"></span>
            <span>دسته‌بندی خدمات</span>
        </x-slot>
        <x-slot name='subtitle'>
            دسته‌بندی خدمات به طور مثال: سئو، طراحی سایت و...
        </x-slot>
        <x-slot name='body'>
            @include('admin.types.layouts.form')
            <x-ui.table.Table :attr="['id' => 'types-table']" :header="['#', 'نام', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($types as $type)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="">
                                    {{ $type->name }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <form method="post" action='{{ route('types.destroy', $type->id) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button.Delete />
                                    </form>


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

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$types" />
        </x-slot>
    </x-ui.card.Card>
@endsection
