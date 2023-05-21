<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <x-dashboard.SidebarNav>
            <x-dashboard.SidebarTitle />

            <x-dashboard.SidebarItem icon='sliders' title='داشبورد' route='dashboard' />

            <x-dashboard.SidebarItemMulti icon='users' active="{{ is_route_active(true, 'customers') }}" id='customers'
                title="مشتریان" :items="[
                    'افزودن مشتری' => 'customers.create',
                    'مدیریت مشتریان' => 'customers.index',
                ]" />

            <x-dashboard.SidebarItemMulti icon='umbrella' active="{{ is_route_active(true, 'companies') }}"
                id='companies' title="مجموعه‌ها" :items="[
                    'افزودن مجموعه' => 'companies.create',
                    'مدیریت مجموعه‌ها' => 'companies.index',
                ]" />

            <x-dashboard.SidebarItemMulti icon='star' active="{{ is_route_active(true, 'types', 'services') }}"
                id='services' title="خدمات" :items="[
                    'خدمات' => 'services.index',
                    'دسته بندی خدمات' => 'types.index',
                ]" />


            <x-dashboard.SidebarItemMulti icon='credit-card' active="{{ is_route_active(true, 'cards') }}"
            id='cards' title="حساب‌ها" :items="[
                'افزودن حساب' => 'cards.create',
                'مدیرت حساب‌ها' => 'cards.index',
            ]" />

            <x-dashboard.SidebarItemMulti icon='file-text' active="{{ is_route_active(true, 'contracts') }}"
            id='contracts' title="قراردادها" :items="[
                'افزودن قرارداد' => 'contracts.create',
                'مدیرت قراردادها' => 'contracts.index',
            ]" />


        </x-dashboard.SidebarNav>
    </div>
</nav>
