<li class="sidebar-item {{ !empty($active) ? 'active' : '' }}">
    <a data-bs-target="#{{ $id }}" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
        <span data-feather="users"></span>
        <span class="align-middle">{{ $title }}</span>
    </a>

    <ul id="{{ $id }}" class="sidebar-dropdown list-unstyled collapse {{ !empty($active) ? 'show' : '' }}"
        data-bs-parent="#sidebar">
        @foreach ($items as $title => $route)
            <li class="sidebar-item {{ is_route_active($route) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route($route) ?? '#' }}">{{ $title }}</a>
            </li>
        @endforeach

        @if (!empty($title1))
            <li class="sidebar-item">
                <a data-bs-target="#{{ $id }}-2" data-bs-toggle="collapse" class="sidebar-link collapsed"
                    aria-expanded="false">{{ $title1 }}</a>
                <ul id="{{ $id }}-2" class="sidebar-dropdown list-unstyled collapse">
                    @foreach ($items2 as $title => $route)
                        <li class="sidebar-item {{ is_route_active($route) ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route($route) ?? '#' }}">{{ $title }}</a>
                        </li>
                    @endforeach

                    @if (!empty($title2))
                        <li class="sidebar-item">
                            <a data-bs-target="#{{ $id }}-3" data-bs-toggle="collapse"
                                class="sidebar-link collapsed" aria-expanded="false">{{ $title2 }}</a>
                            <ul id="{{ $id }}-3" class="sidebar-dropdown list-unstyled collapse">
                                @foreach ($items3 as $title => $route)
                                    <li class="sidebar-item {{ is_route_active($route) ? 'active' : '' }}">
                                        <a class="sidebar-link"
                                            href="{{ route($route) ?? '#' }}">{{ $title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
</li>
