@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="star"></span>
            <span>خدمات</span>
        </x-slot>
        <x-slot name='subtitle'>
            خدمات هر دسته بندی مثال: بنر صفحه باغ تالار، بنر صفحه اصلی و...
        </x-slot>
        <x-slot name='body'>
            @include('admin.services.layouts.form')
            <x-ui.table.Table :attr="['id' => 'services-table']" :header="['#', 'نام', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="">
                                    {{ $service->name }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <form method="post" action='{{ route('services.destroy', $service->id) }}'>
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

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$services" />
        </x-slot>
    </x-ui.card.Card>
@endsection
