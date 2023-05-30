@if (!empty($label))
<li class="sidebar-header">
    {{ $label }}
</li>

@endif
<li class="sidebar-item {{ !empty($active) ? 'active' : ( !empty($route) && is_route_active(false,$route) ? 'active' : '' ) }}">
    <a class="sidebar-link" href="{{!empty($href) ? $href : (!empty($route)  ? route($route)   : '#' )  }}">
        <i class="align-middle" data-feather="{{ $icon ?? '' }}"></i>
        <span class="align-middle">{{ $title }}</span>
    </a>
</li>
