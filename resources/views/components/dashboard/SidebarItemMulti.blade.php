<li class="sidebar-item">
    <a data-bs-target="#{{ $id }}" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-corner-right-down align-middle">
            <polyline points="10 15 15 20 20 15"></polyline>
            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
        </svg>
        <span class="align-middle">{{ $title1 }}</span>
    </a>

    @if (!empty($title2))
        <ul id="{{ $id }}" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a data-bs-target="#{{ $id }}-2" data-bs-toggle="collapse" class="sidebar-link collapsed"
                    aria-expanded="false">{{ $title2 }}</a>
                <ul id="{{ $id }}-2" class="sidebar-dropdown list-unstyled collapse">
                    @foreach ($items2 as $title => $link)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ $link }}">{{ $title }}</a>
                        </li>
                    @endforeach

                    @if (!empty($title3))
                        <li class="sidebar-item">
                            <a data-bs-target="#{{ $id }}-3" data-bs-toggle="collapse"
                                class="sidebar-link collapsed" aria-expanded="false">{{ $title3 }}</a>
                            <ul id="{{ $id }}-3" class="sidebar-dropdown list-unstyled collapse">
                                @foreach ($items3 as $title => $link)
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="{{ $link }}">{{ $title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>

        </ul>
    @endif
</li>

