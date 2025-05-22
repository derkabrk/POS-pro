<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('business.dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="17">
            </span>
        </a>
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
    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('business.dashboard.index') ? 'active' : '' }}" href="{{ route('business.dashboard.index') }}">
                        <i class="ri-dashboard-line"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @if (auth()->user()->role != 'staff' || visible_permission('salePermission') || visible_permission('salesListPermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.sales.index', 'business.sales.create', 'business.sales.edit', 'business.sale-returns.create', 'business.sale-returns.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-shopping-cart-line"></i>
                            <span>{{ __('Sales') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @if (auth()->user()->role != 'staff' || visible_permission('salePermission'))
                                <li><a class="dropdown-item {{ Request::routeIs('business.sales.create') ? 'active' : '' }}" href="{{ route('business.sales.create') }}">{{ __('Sale New') }}</a></li>
                            @endif
                            @if (auth()->user()->role != 'staff' || visible_permission('salesListPermission'))
                                <li><a class="dropdown-item {{ Request::routeIs('business.sales.index', 'business.sale-returns.create') ? 'active' : '' }}" href="{{ route('business.sales.index') }}">{{ __('Sale List') }}</a></li>
                                <li><a class="dropdown-item {{ Request::routeIs('business.sale-returns.index') ? 'active' : '' }}" href="{{ route('business.sale-returns.index') }}">{{ __('Sales Return') }}</a></li>
                                <li><a class="dropdown-item {{ Request::routeIs('business.sale-confirme.index') ? 'active' : '' }}" href="{{ route('business.sale-confirme.index') }}">{{ __('Confirme Sales') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission') || visible_permission('purchaseListPermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.purchases.index', 'business.purchases.create', 'business.purchases.edit', 'business.purchase-returns.create', 'business.purchase-returns.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-file-list-3-line"></i>
                            <span>{{ __('Purchases') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission'))
                                <li><a class="dropdown-item {{ Request::routeIs('business.purchases.create') ? 'active' : '' }}" href="{{ route('business.purchases.create') }}">{{ __('Purchase New') }}</a></li>
                            @endif
                            @if (auth()->user()->role != 'staff' || visible_permission('purchaseListPermission'))
                                <li><a class="dropdown-item {{ Request::routeIs('business.purchases.index', 'business.purchase-returns.create') ? 'active' : '' }}" href="{{ route('business.purchases.index') }}">{{ __('Purchase List') }}</a></li>
                                <li><a class="dropdown-item {{ Request::routeIs('business.purchase-returns.index') ? 'active' : '' }}" href="{{ route('business.purchase-returns.index') }}">{{ __('Purchase Return') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('productPermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.products.index', 'business.products.create', 'business.products.edit', 'business.categories.index', 'business.brands.index', 'business.units.index', 'business.barcodes.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-box-line"></i>
                            <span>{{ __('Products') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.products.index') ? 'active' : '' }}" href="{{ route('business.products.index') }}">{{ __('All Product') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.products.create') ? 'active' : '' }}" href="{{ route('business.products.create') }}">{{ __('Add Product') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.barcodes.index') ? 'active' : '' }}" href="{{ route('business.barcodes.index') }}">{{ __('Print Labels') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.categories.index') ? 'active' : '' }}" href="{{ route('business.categories.index') }}">{{ __('Category') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.brands.index') ? 'active' : '' }}" href="{{ route('business.brands.index') }}">{{ __('Brand') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.units.index') ? 'active' : '' }}" href="{{ route('business.units.index') }}">{{ __('Unit') }}</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('stockPermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.stocks.index', 'business.expired-products.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-stack-line"></i>
                            <span>{{ __('Stock List') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.stocks.index') && !request('alert_qty') ? 'active' : '' }}" href="{{ route('business.stocks.index') }}">{{ __('All Stock') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.stocks.index') && request('alert_qty') ? 'active' : '' }}" href="{{ route('business.stocks.index', ['alert_qty' => true]) }}">{{ __('Low Stock') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.expired-products.index') ? 'active' : '' }}" href="{{ route('business.expired-products.index') }}">{{ __('Expired Products') }}</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('partiesPermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ (Request::routeIs('business.parties.index') && request('type') == 'Customer') || (Request::routeIs('business.parties.create') && request('type') == 'Customer') || (Request::routeIs('business.parties.edit') && request('type') == 'Customer') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-user-line"></i>
                            <span>{{ __('Customers') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.parties.index') && request('type') == 'Customer' ? 'active' : '' }}" href="{{ route('business.parties.index', ['type' => 'Customer']) }}">{{ __('All Customers') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.parties.create') && request('type') == 'Customer' ? 'active' : '' }}" href="{{ route('business.parties.create', ['type' => 'Customer']) }}">{{ __('Add Customer') }}</a></li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('business.suppliers.index') ? 'active' : '' }}" href="{{ route('business.suppliers.index') }}">
                        <i class="ri-truck-line"></i>
                        <span>{{ __('Suppliers') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role != 'staff' || visible_permission('addIncomePermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.incomes.index', 'business.income-categories.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-money-dollar-circle-line"></i>
                            <span>{{ __('Incomes') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.incomes.index') ? 'active' : '' }}" href="{{ route('business.incomes.index') }}">{{ __('Income') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.income-categories.index') ? 'active' : '' }}" href="{{ route('business.income-categories.index') }}">{{ __('Income Category') }}</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('shippingPermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.shipping.index', 'business.shipping.create') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-ship-line"></i>
                            <span>{{ __('Shipping') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.shipping.index') ? 'active' : '' }}" href="{{ route('business.shipping.index') }}">{{ __('All Services') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.shipping.create') ? 'active' : '' }}" href="{{ route('business.shipping.create') }}">{{ __('Add Service') }}</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('orderSourcePermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.orderSource.index', 'business.orderSource.create', 'business.orderSource.edit') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-source-line"></i>
                            <span>{{ __('Order Sources') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.orderSource.index') ? 'active' : '' }}" href="{{ route('business.orderSource.index') }}">{{ __('All Order Sources') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.orderSource.create') ? 'active' : '' }}" href="{{ route('business.orderSource.create') }}">{{ __('Add Order Source') }}</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('addExpensePermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.expense-categories.index', 'business.expenses.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-money-cny-circle-line"></i>
                            <span>{{ __('Expenses') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.expenses.index') ? 'active' : '' }}" href="{{ route('business.expenses.index') }}">{{ __('Expense') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.expense-categories.index') ? 'active' : '' }}" href="{{ route('business.expense-categories.index') }}">{{ __('Expense Category') }}</a></li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('business.vats.index') ? 'active' : '' }}" href="{{ route('business.vats.index') }}">
                        <i class="ri-percent-line"></i>
                        <span>{{ __('Vat & Tax') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role != 'staff' || visible_permission('dueListPermission'))
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('business.dues.index', 'business.collect.dues') ? 'active' : '' }}" href="{{ route('business.dues.index') }}">
                            <i class="ri-file-list-line"></i>
                            <span>{{ __('Due List') }}</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('business.subscriptions.index') ? 'active' : '' }}" href="{{ route('business.subscriptions.index') }}">
                        <i class="ri-subscription-line"></i>
                        <span>{{ __('Subscriptions') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role != 'staff' || visible_permission('lossProfitPermission'))
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('business.loss-profits.index') ? 'active' : '' }}" href="{{ route('business.loss-profits.index') }}">
                            <i class="ri-line-chart-line"></i>
                            <span>{{ __('Profit & Loss List') }}</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff' || visible_permission('reportsPermission'))
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.income-reports.index', 'business.expense-reports.index', 'business.stock-reports.index', 'business.loss-profit-reports.index', 'business.sale-reports.index', 'business.purchase-reports.index', 'business.due-reports.index', 'business.sale-return-reports.index', 'business.purchase-return-reports.index', 'business.supplier-due-reports.index', 'business.transaction-history-reports.index', 'business.subscription-reports.index', 'business.expired-product-reports.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-bar-chart-line"></i>
                            <span>{{ __('Reports') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.sale-reports.index') ? 'active' : '' }}" href="{{ route('business.sale-reports.index') }}">{{ __('Sale') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.sale-return-reports.index') ? 'active' : '' }}" href="{{ route('business.sale-return-reports.index') }}">{{ __('Sale Return') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.purchase-reports.index') ? 'active' : '' }}" href="{{ route('business.purchase-reports.index') }}">{{ __('Purchase') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.purchase-return-reports.index') ? 'active' : '' }}" href="{{ route('business.purchase-return-reports.index') }}">{{ __('Purchase Return') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.income-reports.index') ? 'active' : '' }}" href="{{ route('business.income-reports.index') }}">{{ __('All Income') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.expense-reports.index') ? 'active' : '' }}" href="{{ route('business.expense-reports.index') }}">{{ __('All Expense') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.stock-reports.index') ? 'active' : '' }}" href="{{ route('business.stock-reports.index') }}">{{ __('Current Stock') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.due-reports.index') ? 'active' : '' }}" href="{{ route('business.due-reports.index') }}">{{ __('Customer Due') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.supplier-due-reports.index') ? 'active' : '' }}" href="{{ route('business.supplier-due-reports.index') }}">{{ __('Supplier Due') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.loss-profit-reports.index') ? 'active' : '' }}" href="{{ route('business.loss-profit-reports.index') }}">{{ __('Loss & Profit') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.transaction-history-reports.index') ? 'active' : '' }}" href="{{ route('business.transaction-history-reports.index') }}">{{ __('Transaction') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.subscription-reports.index') ? 'active' : '' }}" href="{{ route('business.subscription-reports.index') }}">{{ __('Subscription Report') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.expired-product-reports.index') ? 'active' : '' }}" href="{{ route('business.expired-product-reports.index') }}">{{ __('Expired Product') }}</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff')
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.ticketSystem.index', 'business.ticketSystem.create') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-ticket-line"></i>
                            <span>{{ __('Ticket System') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.ticketSystem.index') ? 'active' : '' }}" href="{{ route('business.ticketSystem.index') }}">{{ __('All Tickets') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.ticketSystem.create') ? 'active' : '' }}" href="{{ route('business.ticketSystem.create') }}">{{ __('Create Ticket') }}</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->role != 'staff')
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('business.settings.index', 'business.roles.index', 'business.roles.edit', 'business.roles.create', 'business.currencies.index', 'business.currencies.create', 'business.currencies.edit', 'business.notifications.index', 'business.payment-types.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-settings-3-line"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::routeIs('business.currencies.index', 'business.currencies.create', 'business.currencies.edit') ? 'active' : '' }}" href="{{ route('business.currencies.index') }}">{{ __('Currencies') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.notifications.index') ? 'active' : '' }}" href="{{ route('business.notifications.index') }}">{{ __('Notifications') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.settings.index') ? 'active' : '' }}" href="{{ route('business.settings.index') }}">{{ __('General Settings') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.roles.index', 'business.roles.create', 'business.roles.edit') ? 'active' : '' }}" href="{{ route('business.roles.index') }}">{{ __('User Role') }}</a></li>
                            <li><a class="dropdown-item {{ Request::routeIs('business.payment-types.index') ? 'active' : '' }}" href="{{ route('business.payment-types.index') }}">{{ __('Payment Type') }}</a></li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ get_option('general')['app_link'] ?? '' }}" target="_blank">
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
</div>
