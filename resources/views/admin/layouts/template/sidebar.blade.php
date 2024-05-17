<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <x-dashboard.SidebarNav>
            <x-dashboard.SidebarTitle />

            <x-dashboard.SidebarItem icon='sliders' title='داشبورد' route="admin.dashboard" />

            <x-dashboard.SidebarItemMulti icon='users' active="{{ is_url_active('admin/customers') }}" id='customers'
                title="مشتریان" :items="[
                    'افزودن مشتری' => 'customers.create',
                    'مدیریت مشتریان' => 'customers.index',
                ]" />

            <x-dashboard.SidebarItemMulti icon='umbrella' active="{{ is_url_active('admin/companies') }}" id='companies'
                title="مجموعه‌ها" :items="[
                    'افزودن مجموعه' => 'companies.create',
                    'مدیریت مجموعه‌ها' => 'companies.index',
                ]" />



            @if (auth()->user()->role != 'user')
                <x-dashboard.SidebarItemMulti icon='star'
                    active="{{ is_url_active(null, 'admin/types', 'services') }}" id='services' title="خدمات"
                    :items="[
                        'خدمات' => 'services.index',
                        'دسته بندی خدمات' => 'types.index',
                    ]" />

                <x-dashboard.SidebarItemMulti icon='credit-card' active="{{ is_url_active('admin/cards') }}"
                    id='cards' title="حساب‌ها" :items="[
                        'افزودن حساب' => 'cards.create',
                        'مدیریت حساب‌ها' => 'cards.index',
                    ]" />
            @endif

            <x-dashboard.SidebarItemMulti icon='file-text'
                active="{{ is_url_active(null, 'admin/contracts', 'admin/installments', 'admin/receives') }}"
                id='contracts' title="قراردادها" :items="[
                    'افزودن قرارداد' => 'contracts.create',
                    'مدیریت قراردادها' => 'contracts.index',
                ]" />


            <x-dashboard.SidebarItemMulti icon='shopping-bag' active="{{ is_url_active('admin/costs') }}" id='costs'
                title="هزینه‌ها" :items="[
                    'افزودن قرارداد' => 'costs.create',
                    'مدیریت هزینه‌ها' => 'costs.index',
                ]" />

            <x-dashboard.SidebarItemMulti icon='dollar-sign' active="{{ is_url_active('admin/payments') }}" id='payments'
                title="پرداخت‌ و خروج از حساب" :items="[
                    'ثبت پرداختی' => 'payments.create',
                    'مدیریت پرداخت‌ها' => 'payments.index',
                ]" />



            @if (in_array(auth()->user()->role, ['manager', 'developer']))
                <x-dashboard.SidebarItemMultiDeep active="{{ is_url_active(['reports.list', 'reports.select-date']) }}"
                    icon='folder' id='reports' title='گزارش‌ گیری' :items="[
                        [
                            'title' => 'مطالبات',
                            'active' => is_url_active(fn() => request()->type == 'installment'),
                            'routes' => [
                                [
                                    'text' => 'روز',
                                    'url' => route('reports.list', [
                                        'type' => 'installment',
                                        'period' => 'day',
                                        'directory' => 'installments',
                                    ]),
                                    'active' => is_url_active('installment/day'),
                                ],
                                [
                                    'text' => 'هفته',
                                    'url' => route('reports.list', [
                                        'type' => 'installment',
                                        'period' => 'week',
                                        'directory' => 'installments',
                                    ]),
                                    'active' => is_url_active('installment/week'),
                                ],
                                [
                                    'text' => 'ماه',
                                    'url' => route('reports.list', [
                                        'type' => 'installment',
                                        'period' => 'month',
                                        'directory' => 'installments',
                                    ]),
                                    'active' => is_url_active('installment/month'),
                                ],
                                [
                                    'text' => 'سال',
                                    'url' => route('reports.list', [
                                        'type' => 'installment',
                                        'period' => 'year',
                                        'directory' => 'installments',
                                    ]),
                                    'active' => is_url_active('installment/year'),
                                ],
                                [
                                    'text' => 'تاریخ انتخابی',
                                    'url' => route('reports.select-date', [
                                        'type' => 'installment',
                                        'directory' => 'installments',
                                    ]),
                                    'active' => is_url_active(null, 'select-date/installment', 'installment/selected'),
                                ],
                            ],
                        ],
                        [
                            'title' => 'وصولی‌ها',
                            'active' => is_url_active(fn() => request()->type == 'receive'),
                            'routes' => [
                                [
                                    'text' => 'روز',
                                    'url' => route('reports.list', [
                                        'type' => 'receive',
                                        'period' => 'day',
                                        'directory' => 'receives',
                                    ]),
                                    'active' => is_url_active('receive/day'),
                                ],
                                [
                                    'text' => 'هفته',
                                    'url' => route('reports.list', [
                                        'type' => 'receive',
                                        'period' => 'week',
                                        'directory' => 'receives',
                                    ]),
                                    'active' => is_url_active('receive/week'),
                                ],
                                [
                                    'text' => 'ماه',
                                    'url' => route('reports.list', [
                                        'type' => 'receive',
                                        'period' => 'month',
                                        'directory' => 'receives',
                                    ]),
                                    'active' => is_url_active('receive/month'),
                                ],
                                [
                                    'text' => 'سال',
                                    'url' => route('reports.list', [
                                        'type' => 'receive',
                                        'period' => 'year',
                                        'directory' => 'receives',
                                    ]),
                                    'active' => is_url_active('receive/year'),
                                ],
                                [
                                    'text' => 'تاریخ انتخابی',
                                    'url' => route('reports.select-date', [
                                        'type' => 'receive',
                                        'directory' => 'receives',
                                    ]),
                                    'active' => is_url_active(null, 'select-date/receive', 'receive/selected'),
                                ],
                            ],
                        ],
                    ]" />
            @endif

            @if (auth()->user()->role != 'user')
                <x-dashboard.SidebarItem icon='pen-tool' title='چک‌ها' route="checks.index" />
            @endif
        </x-dashboard.SidebarNav>
    </div>
</nav>
