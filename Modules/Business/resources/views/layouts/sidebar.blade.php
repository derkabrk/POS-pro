<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('business.dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('business.dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar" style="height: 100vh; overflow-y: auto;">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('business.dashboard.index') ? 'active' : '' }}" href="{{ route('business.dashboard.index') }}">
                        <i class="ri-dashboard-line"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @if (auth()->user()->role != 'staff' || visible_permission('salePermission') || visible_permission('salesListPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.sales.index', 'business.sales.create', 'business.sales.edit', 'business.sale-returns.create', 'business.sale-returns.index') ? 'active' : '' }}" href="#sidebarSales" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.sales.index', 'business.sales.create', 'business.sales.edit', 'business.sale-returns.create', 'business.sale-returns.index') ? 'true' : 'false' }}" aria-controls="sidebarSales">
                            <i class="ri-shopping-cart-line"></i>
                            <span>{{ __('Sales') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.sales.index', 'business.sales.create', 'business.sales.edit', 'business.sale-returns.create', 'business.sale-returns.index') ? 'show' : '' }}" id="sidebarSales">
                            <ul class="nav nav-sm flex-column">
                            @if (auth()->user()->role != 'staff' || visible_permission('salePermission'))
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.sales.create') ? 'active' : '' }}" href="{{ route('business.sales.create') }}">{{ __('Sale New') }}</a></li>
                            @endif
                            @if (auth()->user()->role != 'staff' || visible_permission('salesListPermission'))
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.sales.index', 'business.sale-returns.create') ? 'active' : '' }}" href="{{ route('business.sales.index') }}">{{ __('Sale List') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.sale-returns.index') ? 'active' : '' }}" href="{{ route('business.sale-returns.index') }}">{{ __('Sales Return') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.sale-confirme.index') ? 'active' : '' }}" href="{{ route('business.sale-confirme.index') }}">{{ __('Confirme Sales') }}</a></li>
                            @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission') || visible_permission('purchaseListPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.purchases.index', 'business.purchases.create', 'business.purchases.edit', 'business.purchase-returns.create', 'business.purchase-returns.index') ? 'active' : '' }}" href="#sidebarPurchases" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.purchases.index', 'business.purchases.create', 'business.purchases.edit', 'business.purchase-returns.create', 'business.purchase-returns.index') ? 'true' : 'false' }}" aria-controls="sidebarPurchases">
                            <i class="ri-file-list-3-line"></i>
                            <span>{{ __('Purchases') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.purchases.index', 'business.purchases.create', 'business.purchases.edit', 'business.purchase-returns.create', 'business.purchase-returns.index') ? 'show' : '' }}" id="sidebarPurchases">
                            <ul class="nav nav-sm flex-column">
                            @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission'))
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.purchases.create') ? 'active' : '' }}" href="{{ route('business.purchases.create') }}">{{ __('Purchase New') }}</a></li>
                            @endif
                            @if (auth()->user()->role != 'staff' || visible_permission('purchaseListPermission'))
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.purchases.index', 'business.purchase-returns.create') ? 'active' : '' }}" href="{{ route('business.purchases.index') }}">{{ __('Purchase List') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.purchase-returns.index') ? 'active' : '' }}" href="{{ route('business.purchase-returns.index') }}">{{ __('Purchase Return') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('productPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.products.index', 'business.products.create', 'business.products.edit', 'business.categories.index', 'business.brands.index', 'business.units.index', 'business.barcodes.index') ? 'active' : '' }}" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.products.index', 'business.products.create', 'business.products.edit', 'business.categories.index', 'business.brands.index', 'business.units.index', 'business.barcodes.index') ? 'true' : 'false' }}" aria-controls="sidebarProducts">
                            <i class="ri-box-line"></i>
                            <span>{{ __('Products') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.products.index', 'business.products.create', 'business.products.edit', 'business.categories.index', 'business.brands.index', 'business.units.index', 'business.barcodes.index') ? 'show' : '' }}" id="sidebarProducts">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.products.index') ? 'active' : '' }}" href="{{ route('business.products.index') }}">{{ __('All Product') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.products.create') ? 'active' : '' }}" href="{{ route('business.products.create') }}">{{ __('Add Product') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.barcodes.index') ? 'active' : '' }}" href="{{ route('business.barcodes.index') }}">{{ __('Print Labels') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.categories.index') ? 'active' : '' }}" href="{{ route('business.categories.index') }}">{{ __('Category') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.brands.index') ? 'active' : '' }}" href="{{ route('business.brands.index') }}">{{ __('Brand') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.units.index') ? 'active' : '' }}" href="{{ route('business.units.index') }}">{{ __('Unit') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('stockPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.stocks.index', 'business.expired-products.index') ? 'active' : '' }}" href="#sidebarStocks" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.stocks.index', 'business.expired-products.index') ? 'true' : 'false' }}" aria-controls="sidebarStocks">
                            <i class="ri-stack-line"></i>
                            <span>{{ __('Stock List') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.stocks.index', 'business.expired-products.index') ? 'show' : '' }}" id="sidebarStocks">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.stocks.index') && !request('alert_qty') ? 'active' : '' }}" href="{{ route('business.stocks.index') }}">{{ __('All Stock') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.stocks.index') && request('alert_qty') ? 'active' : '' }}" href="{{ route('business.stocks.index', ['alert_qty' => true]) }}">{{ __('Low Stock') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.expired-products.index') ? 'active' : '' }}" href="{{ route('business.expired-products.index') }}">{{ __('Expired Products') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('partiesPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ (Request::routeIs('business.parties.index') && request('type') == 'Customer') || (Request::routeIs('business.parties.create') && request('type') == 'Customer') || (Request::routeIs('business.parties.edit') && request('type') == 'Customer') ? 'active' : '' }}" href="#sidebarCustomers" data-bs-toggle="collapse" role="button" aria-expanded="{{ (Request::routeIs('business.parties.index') && request('type') == 'Customer') || (Request::routeIs('business.parties.create') && request('type') == 'Customer') || (Request::routeIs('business.parties.edit') && request('type') == 'Customer') ? 'true' : 'false' }}" aria-controls="sidebarCustomers">
                            <i class="ri-user-line"></i>
                            <span>{{ __('Customers') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ (Request::routeIs('business.parties.index') && request('type') == 'Customer') || (Request::routeIs('business.parties.create') && request('type') == 'Customer') || (Request::routeIs('business.parties.edit') && request('type') == 'Customer') ? 'show' : '' }}" id="sidebarCustomers">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.parties.index') && request('type') == 'Customer' ? 'active' : '' }}" href="{{ route('business.parties.index', ['type' => 'Customer']) }}">{{ __('All Customers') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.parties.create') && request('type') == 'Customer' ? 'active' : '' }}" href="{{ route('business.parties.create', ['type' => 'Customer']) }}">{{ __('Add Customer') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('business.suppliers.index') ? 'active' : '' }}" href="{{ route('business.suppliers.index') }}">
                        <i class="ri-truck-line"></i>
                        <span>{{ __('Suppliers') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role != 'staff' || visible_permission('orderSourcePermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.orderSource.index', 'business.orderSource.create', 'business.orderSource.edit') ? 'active' : '' }}" href="#sidebarOrderSources" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.orderSource.index', 'business.orderSource.create', 'business.orderSource.edit') ? 'true' : 'false' }}" aria-controls="sidebarOrderSources">
                            <i class="bi bi-diagram-3-fill"></i>
                            <span>{{ __('Order Sources') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.orderSource.index', 'business.orderSource.create', 'business.orderSource.edit') ? 'show' : '' }}" id="sidebarOrderSources">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.orderSource.index') ? 'active' : '' }}" href="{{ route('business.orderSource.index') }}">{{ __('All Order Sources') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.orderSource.create') ? 'active' : '' }}" href="{{ route('business.orderSource.create') }}">{{ __('Add Order Source') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if(auth()->user()->hasPlanPermission('bulk_message'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::routeIs('business.bulk-message.create') ? 'active' : '' }}" href="{{ route('business.bulk-message.create') }}">
                            <i class="bi bi-envelope-paper-fill me-2"></i>
                            <span>{{ __('Email Bulking') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::routeIs('business.bulk-message.index') ? 'active' : '' }}" href="{{ route('business.bulk-message.index') }}">
                            <i class="bi bi-envelope-paper-fill me-2"></i>
                            <span>{{ __('Sent Bulk Messages') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('addIncomePermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.incomes.index', 'business.income-categories.index') ? 'active' : '' }}" href="#sidebarIncomes" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.incomes.index', 'business.income-categories.index') ? 'true' : 'false' }}" aria-controls="sidebarIncomes">
                            <i class="ri-money-dollar-circle-line"></i>
                            <span>{{ __('Incomes') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.incomes.index', 'business.income-categories.index') ? 'show' : '' }}" id="sidebarIncomes">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.incomes.index') ? 'active' : '' }}" href="{{ route('business.incomes.index') }}">{{ __('Income') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.income-categories.index') ? 'active' : '' }}" href="{{ route('business.income-categories.index') }}">{{ __('Income Category') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('shippingPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.shipping.index', 'business.shipping.create') ? 'active' : '' }}" href="#sidebarShipping" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.shipping.index', 'business.shipping.create') ? 'true' : 'false' }}" aria-controls="sidebarShipping">
                            <i class="ri-ship-line"></i>
                            <span>{{ __('Shipping') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.shipping.index', 'business.shipping.create') ? 'show' : '' }}" id="sidebarShipping">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.shipping.index') ? 'active' : '' }}" href="{{ route('business.shipping.index') }}">{{ __('All Services') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.shipping.create') ? 'active' : '' }}" href="{{ route('business.shipping.create') }}">{{ __('Add Service') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('addExpensePermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.expense-categories.index', 'business.expenses.index') ? 'active' : '' }}" href="#sidebarExpenses" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.expense-categories.index', 'business.expenses.index') ? 'true' : 'false' }}" aria-controls="sidebarExpenses">
                            <i class="ri-money-cny-circle-line"></i>
                            <span>{{ __('Expenses') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.expense-categories.index', 'business.expenses.index') ? 'show' : '' }}" id="sidebarExpenses">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.expenses.index') ? 'active' : '' }}" href="{{ route('business.expenses.index') }}">{{ __('Expense') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.expense-categories.index') ? 'active' : '' }}" href="{{ route('business.expense-categories.index') }}">{{ __('Expense Category') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('business.vats.index') ? 'active' : '' }}" href="{{ route('business.vats.index') }}">
                        <i class="ri-percent-line"></i>
                        <span>{{ __('Vat & Tax') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role != 'staff' || visible_permission('dueListPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::routeIs('business.dues.index', 'business.collect.dues') ? 'active' : '' }}" href="{{ route('business.dues.index') }}">
                            <i class="ri-file-list-line"></i>
                            <span>{{ __('Due List') }}</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('business.subscriptions.index') ? 'active' : '' }}" href="{{ route('business.subscriptions.index') }}">
                        <i class="ri-subscription-line"></i>
                        <span>{{ __('Subscriptions') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role != 'staff' || visible_permission('lossProfitPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::routeIs('business.loss-profits.index') ? 'active' : '' }}" href="{{ route('business.loss-profits.index') }}">
                            <i class="ri-line-chart-line"></i>
                            <span>{{ __('Profit & Loss List') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('reportsPermission'))
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.income-reports.index', 'business.expense-reports.index', 'business.sale-reports.index', 'business.purchase-reports.index', 'business.due-reports.index', 'business.sale-return-reports.index', 'business.purchase-return-reports.index', 'business.supplier-due-reports.index') ? 'active' : '' }}" href="#sidebarReports" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.income-reports.index', 'business.expense-reports.index', 'business.sale-reports.index', 'business.purchase-reports.index', 'business.due-reports.index', 'business.sale-return-reports.index', 'business.purchase-return-reports.index', 'business.supplier-due-reports.index') ? 'true' : 'false' }}" aria-controls="sidebarReports">
                            <i class="ri-bar-chart-line"></i>
                            <span>{{ __('Reports') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.income-reports.index', 'business.expense-reports.index', 'business.sale-reports.index', 'business.purchase-reports.index', 'business.due-reports.index', 'business.sale-return-reports.index', 'business.purchase-return-reports.index', 'business.supplier-due-reports.index') ? 'show' : '' }}" id="sidebarReports">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.sale-reports.index') ? 'active' : '' }}" href="{{ route('business.sale-reports.index') }}">{{ __('Sale') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.sale-return-reports.index') ? 'active' : '' }}" href="{{ route('business.sale-return-reports.index') }}">{{ __('Sale Return') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.purchase-reports.index') ? 'active' : '' }}" href="{{ route('business.purchase-reports.index') }}">{{ __('Purchase') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.purchase-return-reports.index') ? 'active' : '' }}" href="{{ route('business.purchase-return-reports.index') }}">{{ __('Purchase Return') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.income-reports.index') ? 'active' : '' }}" href="{{ route('business.income-reports.index') }}">{{ __('All Income') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.expense-reports.index') ? 'active' : '' }}" href="{{ route('business.expense-reports.index') }}">{{ __('All Expense') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff')
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.ticketSystem.index', 'business.ticketSystem.create') ? 'active' : '' }}" href="#sidebarTickets" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.ticketSystem.index', 'business.ticketSystem.create') ? 'true' : 'false' }}" aria-controls="sidebarTickets">
                            <i class="ri-ticket-line"></i>
                            <span>{{ __('Ticket System') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.ticketSystem.index', 'business.ticketSystem.create') ? 'show' : '' }}" id="sidebarTickets">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.ticketSystem.index') ? 'active' : '' }}" href="{{ route('business.ticketSystem.index') }}">{{ __('All Tickets') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.ticketSystem.create') ? 'active' : '' }}" href="{{ route('business.ticketSystem.create') }}">{{ __('Create Ticket') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff')
                    <li class="nav-item">
                        <a class="nav-link menu-link menu-dropdown {{ Request::routeIs('business.settings.index', 'business.roles.index', 'business.roles.edit', 'business.roles.create', 'business.currencies.index', 'business.currencies.create', 'business.currencies.edit', 'business.notifications.index', 'business.payment-types.index') ? 'active' : '' }}" href="#sidebarSettings" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::routeIs('business.settings.index', 'business.roles.index', 'business.roles.edit', 'business.roles.create', 'business.currencies.index', 'business.currencies.create', 'business.currencies.edit', 'business.notifications.index', 'business.payment-types.index') ? 'true' : 'false' }}" aria-controls="sidebarSettings">
                            <i class="ri-settings-3-line"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Request::routeIs('business.settings.index', 'business.roles.index', 'business.roles.edit', 'business.roles.create', 'business.currencies.index', 'business.currencies.create', 'business.currencies.edit', 'business.notifications.index', 'business.payment-types.index') ? 'show' : '' }}" id="sidebarSettings">
                            <ul class="nav nav-sm flex-column">
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.currencies.index', 'business.currencies.create', 'business.currencies.edit') ? 'active' : '' }}" href="{{ route('business.currencies.index') }}">{{ __('Currencies') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.notifications.index') ? 'active' : '' }}" href="{{ route('business.notifications.index') }}">{{ __('Notifications') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.settings.index') ? 'active' : '' }}" href="{{ route('business.settings.index') }}">{{ __('General Settings') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.roles.index', 'business.roles.create', 'business.roles.edit') ? 'active' : '' }}" href="{{ route('business.roles.index') }}">{{ __('User Role') }}</a></li>
                                <li><a class="nav-link menu-link {{ Request::routeIs('business.payment-types.index') ? 'active' : '' }}" href="{{ route('business.payment-types.index') }}">{{ __('Payment Type') }}</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ get_option('general')['app_link'] ?? '' }}" target="_blank">
                        <i class="ri-download-line"></i>
                        <span>{{ __('Download Apk') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <div id="sidebar_plan" class="d-block sidebar-free-plan d-flex align-items-center justify-content-between p-3 flex-column">
                        <div class="text-center">
                            @if (plan_data() ?? false)
                                <h3>{{ plan_data()['plan']['subscriptionName'] ?? '' }}</h3>
                                <h5>{{ __('Expired') }}: {{ formatted_date(plan_data()['will_expire'] ?? '') }}</h5>
                            @else
                                <h3>{{ __('No Active Plan') }}</h3>
                                <h5>{{ __('Please subscribe to a plan') }}</h5>
                            @endif
                        </div>
                        <a href="{{ route('business.subscriptions.index') }}" class="btn upgrate-btn fw-bold">{{ __('Upgrade Now') }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
