<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <x-dashboard.SidebarNav>
            <x-dashboard.SidebarTitle  />

            <x-dashboard.SidebarItem icon='sliders' title='داشبورد' route='dashboard'   />

            <x-dashboard.SidebarItem icon='users' title='مشتریان'   href="{{ route('customers.index') }}" active="{{ is_route_active('customers.index') }}" />

        </x-dashboard.SidebarNav>
    </div>
</nav>
