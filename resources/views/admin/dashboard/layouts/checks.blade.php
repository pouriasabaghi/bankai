<x-ui.card.Card>
    <x-slot name='header'>
        چک‌های در انتظار وصول
    </x-slot>

    <x-slot name='body'>
        <x-ui.table.Table class="mb-5" :attr="['id' => 'contracts-table']" :header="['نام‌قرارداد', 'مبلغ', 'تماس', 'جزئیات', 'تاریخ']">
            <x-slot name="tbody">
                @forelse($checks as $check)
                    <tr>
                        <td>
                            {{ $check->contract->name }}
                        </td>
                        <td>
                            {{ $check->amount_str }}
                        </td>
                        <td>
                            {{ $check->contract->customer->mobile }}
                        </td>
                        <td>
                            @if (filled($check->contract->id))
                                <x-ui.button.Link class="ms-3"
                                    href="{{ route('receives.create', $check->contract->id) }}#receive-{{ $check->id }}">
                                    مشاهده
                                </x-ui.button.Link>
                            @else
                                <x-ui.button.Link class="ms-3 text-muted" href="#">
                                    مشاهده
                                </x-ui.button.Link>
                            @endif
                        </td>
                        <td>
                            {{ $check->due_at }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-ui.table.Table>
    </x-slot>
</x-ui.card.Card>
