<li class="sidebar-item {{ !empty($active) ? 'active' : '' }}">
    <a data-bs-target="#{{ $id }}" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
        <span data-feather="{{ $icon ?? 'circle' }}"></span>
        <span class="align-middle">{{ $title }}</span>
    </a>
    <ul id="{{ $id }}" class="sidebar-dropdown list-unstyled collapse {{ !empty($active) ? 'show' : '' }}"
        data-bs-parent="#sidebar">
        @foreach ($items as $item)
            <li class="sidebar-item ">
                @if (!empty($item['routes']))
                    <a data-bs-target="#{{ $id }}-{{ $loop->index }}" data-bs-toggle="collapse"
                        class="sidebar-link collapsed" aria-expanded="false">{{ $item['title'] }}</a>
                    <ul id="{{ $id }}-{{ $loop->index }}"
                        class="sidebar-dropdown list-unstyled collapse {{ !empty($item['active']) ? 'show' : '' }}">
                        @foreach ($item['routes'] as $route)
                            <li class="sidebar-item  {{ !empty($route['active']) ? 'active' : '' }}">
                                <a class="sidebar-link" href="{{ $route['url'] }}">{{ $route['text'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <a href="{{ $item['route'] }}" class="sidebar-link ">{{ $item['title'] }}</a>
                @endif
            </li>
        @endforeach
    </ul>
</li>
