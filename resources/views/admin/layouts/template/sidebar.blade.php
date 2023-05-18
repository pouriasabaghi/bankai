<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <x-dashboard.SidebarNav>
            <x-dashboard.SidebarTitle />

            <x-dashboard.SidebarItem icon='sliders' title='داشبورد' route='dashboard' />

            <x-dashboard.SidebarItemMulti active="{{ is_route_active('customers', true) }}" id='customers' title="مشتریان"
                :items="[
                    'افزودن' => 'customers.create',
                    'مدیریت' => 'customers.index',
                ]" />

        </x-dashboard.SidebarNav>
    </div>
</nav>
