<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <x-dashboard.SidebarNav>
            <x-dashboard.SidebarTitle />

            <x-dashboard.SidebarItem icon='sliders' title='داشبورد' route='dashboard' />

            <x-dashboard.SidebarItemMulti icon='users' active="{{ is_route_active('customers', true) }}" id='customers' title="مشتریان"
                :items="[
                    'افزودن' => 'customers.create',
                    'مدیریت' => 'customers.index',
                ]" />

            <x-dashboard.SidebarItemMulti icon='user-check' active="{{ is_route_active('companies', true) }}" id='companies'
                title="مجموعه‌ها" :items="[
                    'افزودن' => 'companies.create',
                    'مدیریت' => 'companies.index',
                ]" />

        </x-dashboard.SidebarNav>
    </div>
</nav>
