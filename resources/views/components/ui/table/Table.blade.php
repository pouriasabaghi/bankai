<style>
    /*
 Label the data
 */
 @php
     $selector = !empty($selector) ? $selector.' td:nth-of-type' : 'td:nth-of-type';
 @endphp
    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {
        @foreach ($header as $item)
            {{ $selector }}({{ $loop->index + 1 }}):after {
                content: "{{ $item }}";
            }
        @endforeach
    }
</style>

<table class=" {{ $class ?? '' }}"
    @if ($attributes = !empty($attr) ? $attr : null) @foreach ($attributes as $key => $attribute)
            {{ $key . '=' . $attribute }}
        @endforeach @endif>
    <x-ui.table.Thead>
        @if (!empty($thead))
            {{ $thead }}
        @else
            @foreach ($header as $item)
                <th>
                    <i class="fas fa-sort fa-xs"></i>
                    {{ $item }}
                </th>
            @endforeach
        @endif

    </x-ui.table.Thead>

    <x-ui.table.Tbody>
        {{ $tbody }}
    </x-ui.table.Tbody>
</table>
