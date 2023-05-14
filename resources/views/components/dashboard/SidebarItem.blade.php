@if (!empty($label))
<li class="sidebar-header">
    {{ $label }}
</li>

@endif
<li class="sidebar-item {{ $active ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ $href ?? '#' }}">
        <i class="align-middle" data-feather="{{ $icon ?? '' }}"></i>
        <span class="align-middle">{{ $title }}</span>
    </a>
</li>
