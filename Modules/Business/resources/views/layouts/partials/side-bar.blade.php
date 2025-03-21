<nav class="side-bar">
    <div class="side-bar-logo">
        <a href="{{ route('business.dashboard.index') }}">
            <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo">
        </a>
        <button class="close-btn"><i class="fal fa-times"></i></button>
    </div>
    <div class="side-bar-manu">
        <ul>
            <li class="{{ Request::routeIs('business.dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('business.dashboard.index') }}" class="active">
                    <span class="sidebar-icon">

                        <img src="{{ asset('assets/images/sidebar/dashborad.svg') }}">

                    </span>
                    {{ __('Dashboard') }}
                </a>
            </li>
            @if (auth()->user()->role != 'staff' ||  visible_permission('salePermission') || visible_permission('salesListPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.sales.index', 'business.sales.create', 'business.sales.edit', 'business.sale-returns.create', 'business.sale-returns.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/sales.svg') }}">

                        </span>
                        {{ __('Sales') }}</a>
                    <ul>
                        @if (auth()->user()->role != 'staff' ||  visible_permission('salePermission'))
                        <li><a class="{{ Request::routeIs('business.sales.create') ? 'active' : '' }}"
                                href="{{ route('business.sales.create') }}">{{ __('Sale New') }}</a></li>
                        @endif
                        @if (auth()->user()->role != 'staff' || visible_permission('salesListPermission'))
                        <li><a class="{{ Request::routeIs('business.sales.index', 'business.sale-returns.create') ? 'active' : '' }}"
                                href="{{ route('business.sales.index') }}">{{ __('Sale List') }}</a></li>
                        <li><a class="{{ Request::routeIs('business.sale-returns.index') ? 'active' : '' }}"
                                href="{{ route('business.sale-returns.index') }}">{{ __('Sales Return') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission') || visible_permission('purchaseListPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.purchases.index', 'business.purchases.create', 'business.purchases.edit', 'business.purchase-returns.create', 'business.purchase-returns.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">

                            <img src="{{ asset('assets/images/sidebar/Purchase.svg') }}">

                        </span>
                        {{ __('Purchases') }}</a>
                    <ul>
                        @if (auth()->user()->role != 'staff' || visible_permission('purchasePermission'))
                        <li><a class="{{ Request::routeIs('business.purchases.create') ? 'active' : '' }}"
                                href="{{ route('business.purchases.create') }}">{{ __('Purchase New') }}</a></li>
                        @endif
                        @if (auth()->user()->role != 'staff' || visible_permission('purchaseListPermission'))
                        <li><a class="{{ Request::routeIs('business.purchases.index',  'business.purchase-returns.create') ? 'active' : '' }}"
                                href="{{ route('business.purchases.index') }}">{{ __('Purchase List') }}</a></li>
                        <li><a class="{{ Request::routeIs('business.purchase-returns.index') ? 'active' : '' }}"
                                href="{{ route('business.purchase-returns.index') }}">{{ __('Purchase Return') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('productPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.products.index', 'business.products.create', 'business.products.edit', 'business.categories.index', 'business.brands.index', 'business.units.index', 'business.barcodes.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/product.svg') }}">

                        </span>
                        {{ __('Products') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.products.index') ? 'active' : '' }}"
                                href="{{ route('business.products.index') }}">{{ __('All Product') }}</a>
                        </li>
                        <li><a class="{{ Request::routeIs('business.products.create') ? 'active' : '' }}"
                                href="{{ route('business.products.create') }}">{{ __('Add Product') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.barcodes.index') ? 'active' : '' }}"
                               href="{{ route('business.barcodes.index') }}">{{ __('Print Labels') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.categories.index') ? 'active' : '' }}"
                                href="{{ route('business.categories.index') }}">{{ __('Category') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.brands.index') ? 'active' : '' }}"
                                href="{{ route('business.brands.index') }}">{{ __('Brand') }}</a>
                        </li>
                        <li>
                            <a class="{{ Request::routeIs('business.units.index') ? 'active' : '' }}"
                                href="{{ route('business.units.index') }}">{{ __('Unit') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('stockPermission'))
                <li class="dropdown {{ Request::routeIs('business.stocks.index','business.expired-products.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/stocklist.svg') }}">
                        </span>
                        {{ __('Stock List') }}
                    </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.stocks.index') && !request('alert_qty')  ? 'active' : '' }}"
                               href="{{ route('business.stocks.index') }}">{{ __('All Stock') }}</a></li>
                        <li><a class="{{ Request::routeIs('business.stocks.index') && request('alert_qty') ? 'active' : '' }}"
                               href="{{ route('business.stocks.index', ['alert_qty' => true]) }}">{{ __('Low Stock') }}</a></li>
                        <li><a class="{{ Request::routeIs('business.expired-products.index') ? 'active' : '' }}"
                               href="{{ route('business.expired-products.index') }}">{{ __('Expired Products') }}</a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('partiesPermission'))
                <li
                    class="dropdown {{ (Request::routeIs('business.parties.index') && request('type') == 'Customer') || (Request::routeIs('business.parties.create') && request('type') == 'Customer') || (Request::routeIs('business.parties.edit') && request('type') == 'Customer') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/customer.svg') }}">

                        </span>
                        {{ __('Customers') }}
                    </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.parties.index') && request('type') == 'Customer' ? 'active' : '' }}"
                                href="{{ route('business.parties.index', ['type' => 'Customer']) }}">{{ __('All Customers') }}</a>
                        </li>
                        <li><a class="{{ Request::routeIs('business.parties.create') && request('type') == 'Customer' ? 'active' : '' }}"
                                href="{{ route('business.parties.create', ['type' => 'Customer']) }}">{{ __('Add Customer') }}</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="dropdown {{ (Request::routeIs('business.parties.index') && request('type') == 'Supplier') || (Request::routeIs('business.parties.create') && request('type') == 'Supplier') || (Request::routeIs('business.parties.edit') && request('type') == 'Supplier') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/supplier.svg') }}">

                        </span>
                        {{ __('Suppliers') }}
                    </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.parties.index') && request('type') == 'Supplier' ? 'active' : '' }}"
                                href="{{ route('business.parties.index', ['type' => 'Supplier']) }}">{{ __('All Suppliers') }}</a>
                        </li>
                        <li><a class="{{ Request::routeIs('business.parties.create') && request('type') == 'Supplier' ? 'active' : '' }}"
                                href="{{ route('business.parties.create', ['type' => 'Supplier']) }}">{{ __('Add Supplier') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('addIncomePermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.incomes.index', 'business.income-categories.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/income.svg') }}">

                        </span>
                        {{ __('Incomes') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.incomes.index') ? 'active' : '' }}"
                                href="{{ route('business.incomes.index') }}">{{ __('Income') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.income-categories.index') ? 'active' : '' }}"
                                href="{{ route('business.income-categories.index') }}">{{ __('Income Category') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->role != 'staff' || visible_permission('addExpensePermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.expense-categories.index', 'business.expenses.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/expenses.svg') }}">

                        </span>
                        {{ __('Expenses') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.expenses.index') ? 'active' : '' }}"
                                href="{{ route('business.expenses.index') }}">{{ __('Expense') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.expense-categories.index') ? 'active' : '' }}"
                                href="{{ route('business.expense-categories.index') }}">{{ __('Expense Category') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="{{ Request::routeIs('business.vats.index') ? 'active' : '' }}">
                <a href="{{ route('business.vats.index') }}" class="active">
                    <span class="sidebar-icon">
                        <img src="{{ asset('assets/images/sidebar/subscription.svg') }}">
                    </span>
                    {{ __('Vat & Tax') }}
                </a>
            </li>

            @if (auth()->user()->role != 'staff' || visible_permission('dueListPermission'))
                <li class="{{ Request::routeIs('business.dues.index', 'business.collect.dues') ? 'active' : '' }}">
                    <a href="{{ route('business.dues.index') }}" class="active">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/duelist.svg') }}">

                        </span>
                        {{ __('Due List') }}
                    </a>
                </li>
            @endif

            <li class="{{ Request::routeIs('business.subscriptions.index') ? 'active' : '' }}">
                <a href="{{ route('business.subscriptions.index') }}" class="active">
                    <span class="sidebar-icon">
                        <img src="{{ asset('assets/images/sidebar/subscription.svg') }}">

                    </span>
                    {{ __('Subscriptions') }}
                </a>
            </li>
            @if (auth()->user()->role != 'staff' || visible_permission('lossProfitPermission'))
                <li class="{{ Request::routeIs('business.loss-profits.index') ? 'active' : '' }}">
                    <a href="{{ route('business.loss-profits.index') }}" class="active">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/loss-profit.svg') }}">

                        </span>
                        {{ __('Profit & Loss List') }}
                    </a>
                </li>
            @endif

            @if (auth()->user()->role != 'staff' || visible_permission('reportsPermission'))
                <li
                    class="dropdown {{ Request::routeIs('business.income-reports.index', 'business.expense-reports.index', 'business.stock-reports.index', 'business.loss-profit-reports.index', 'business.sale-reports.index', 'business.purchase-reports.index', 'business.due-reports.index', 'business.sale-return-reports.index', 'business.purchase-return-reports.index', 'business.supplier-due-reports.index', 'business.transaction-history-reports.index', 'business.subscription-reports.index', 'business.expired-product-reports.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <img src="{{ asset('assets/images/sidebar/Report.svg') }}">

                        </span>
                        {{ __('Reports') }}</a>
                    <ul>
                        <li><a class="{{ Request::routeIs('business.sale-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.sale-reports.index') }}">{{ __('Sale') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.sale-return-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.sale-return-reports.index') }}">{{ __('Sale Return') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.purchase-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.purchase-reports.index') }}">{{ __('Purchase') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.purchase-return-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.purchase-return-reports.index') }}">{{ __('Purchase Return') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.income-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.income-reports.index') }}">{{ __('All Income') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.expense-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.expense-reports.index') }}">{{ __('All Expense') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.stock-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.stock-reports.index') }}">{{ __('Current Stock') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.due-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.due-reports.index') }}">{{ __('Customer Due') }}</a></li>

                        <li><a class="{{ Request::routeIs('business.supplier-due-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.supplier-due-reports.index') }}">{{ __('Supplier Due') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.loss-profit-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.loss-profit-reports.index') }}">{{ __('Loss & Profit') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.transaction-history-reports.index') ? 'active' : '' }}"
                                href="{{ route('business.transaction-history-reports.index') }}">{{ __('Transaction') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.subscription-reports.index') ? 'active' : '' }}"
                            href="{{ route('business.subscription-reports.index') }}">{{ __('Subscription Report') }}</a>
                        </li>

                        <li><a class="{{ Request::routeIs('business.expired-product-reports.index') ? 'active' : '' }}"
                            href="{{ route('business.expired-product-reports.index') }}">{{ __('Expired Product') }}</a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (auth()->user()->role != 'staff')
                <li
                    class="dropdown {{ Request::routeIs('business.settings.index', 'business.roles.index', 'business.roles.edit', 'business.roles.create', 'business.currencies.index', 'business.currencies.create', 'business.currencies.edit', 'business.notifications.index','business.payment-types.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 6.24997C7.93205 6.24997 6.25005 7.93197 6.25005 9.99997C6.25005 12.068 7.93205 13.75 10 13.75C12.068 13.75 13.75 12.068 13.75 9.99997C13.75 7.93197 12.068 6.24997 10 6.24997ZM10 12.25C8.75905 12.25 7.75005 11.241 7.75005 9.99997C7.75005 8.75897 8.75905 7.74997 10 7.74997C11.241 7.74997 12.25 8.75897 12.25 9.99997C12.25 11.241 11.241 12.25 10 12.25ZM19.2081 11.953C18.5141 11.551 18.082 10.803 18.081 9.99997C18.08 9.19897 18.5091 8.45198 19.2121 8.04498C19.7271 7.74598 19.9031 7.08296 19.6051 6.56696L17.9331 3.68097C17.6351 3.16597 16.972 2.98898 16.456 3.28598C15.757 3.68898 14.8881 3.68898 14.1871 3.28198C13.4961 2.88098 13.0661 2.13598 13.0661 1.33698C13.0661 0.737975 12.578 0.250977 11.979 0.250977H8.02403C7.42403 0.250977 6.93706 0.737975 6.93706 1.33698C6.93706 2.13598 6.50704 2.88097 5.81404 3.28397C5.11504 3.68897 4.24705 3.68996 3.54805 3.28696C3.03105 2.98896 2.36906 3.16698 2.07106 3.68198L0.397049 6.57098C0.0990486 7.08598 0.276035 7.74796 0.796035 8.04996C1.48904 8.45096 1.92105 9.19796 1.92305 9.99896C1.92505 10.801 1.49504 11.55 0.793045 11.957C0.543045 12.102 0.363047 12.335 0.289047 12.615C0.215047 12.894 0.253056 13.185 0.398056 13.436L2.06905 16.32C2.36705 16.836 3.03005 17.015 3.54805 16.716C4.24705 16.313 5.11405 16.314 5.80305 16.713L5.80504 16.714C5.80804 16.716 5.81105 16.718 5.81505 16.72C6.50605 17.121 6.93504 17.866 6.93404 18.666C6.93404 19.265 7.42103 19.752 8.02003 19.752H11.979C12.578 19.752 13.065 19.265 13.065 18.667C13.065 17.867 13.495 17.122 14.189 16.719C14.887 16.314 15.755 16.312 16.455 16.716C16.971 17.014 17.6331 16.837 17.9321 16.322L19.606 13.433C19.903 12.916 19.7261 12.253 19.2081 11.953ZM16.831 15.227C15.741 14.752 14.476 14.817 13.434 15.42C12.401 16.019 11.7191 17.078 11.5871 18.25H8.41005C8.28005 17.078 7.59603 16.017 6.56303 15.419C5.52303 14.816 4.25605 14.752 3.16905 15.227L1.89305 13.024C2.84805 12.321 3.42504 11.193 3.42104 9.99298C3.41804 8.80098 2.84204 7.68097 1.89204 6.97797L3.16905 4.77396C4.25705 5.24796 5.52405 5.18396 6.56605 4.57996C7.59805 3.98196 8.28003 2.92198 8.41203 1.75098H11.5871C11.7181 2.92298 12.4011 3.98197 13.4361 4.58197C14.475 5.18497 15.742 5.24896 16.831 4.77496L18.108 6.97797C17.155 7.67997 16.579 8.80597 16.581 10.004C16.582 11.198 17.1581 12.32 18.1091 13.025L16.831 15.227Z"
                                    fill="white" />
                            </svg>
                        </span>
                        {{ __('Settings') }}
                    </a>
                    <ul>

                        <li>
                            <a class="{{ Request::routeIs('business.currencies.index', 'business.currencies.create', 'business.currencies.edit') ? 'active' : '' }}"
                                href="{{ route('business.currencies.index') }}">{{ __('Currencies') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.notifications.index') ? 'active' : '' }}"
                                href="{{ route('business.notifications.index') }}">{{ __('Notifications') }}</a>
                        </li>


                        <li>
                            <a class="{{ Request::routeIs('business.settings.index') ? 'active' : '' }}"
                                href="{{ route('business.settings.index') }}">{{ __('General Settings') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.roles.index', 'business.roles.create', 'business.roles.edit') ? 'active' : '' }}"
                                href="{{ route('business.roles.index') }}">{{ __('User Role') }}</a>
                        </li>

                        <li>
                            <a class="{{ Request::routeIs('business.payment-types.index') ? 'active' : '' }}"
                                href="{{ route('business.payment-types.index') }}">{{ __('Payment Type') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li>
                <a href="{{ get_option('general')['app_link'] ?? '' }}" target="_blank" class="active">
                    <span class="sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M537.6 226.6c4.1-10.7 6.4-22.4 6.4-34.6 0-53-43-96-96-96-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32c-88.4 0-160 71.6-160 160 0 2.7 .1 5.4 .2 8.1C40.2 219.8 0 273.2 0 336c0 79.5 64.5 144 144 144h368c70.7 0 128-57.3 128-128 0-61.9-44-113.6-102.4-125.4zm-132.9 88.7L299.3 420.7c-6.2 6.2-16.4 6.2-22.6 0L171.3 315.3c-10.1-10.1-2.9-27.3 11.3-27.3H248V176c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v112h65.4c14.2 0 21.4 17.2 11.3 27.3z" />
                        </svg>
                    </span>
                    {{ __('Download Apk') }}
                </a>
            </li>

            <li>
                <div id="sidebar_plan" class="d-block sidebar-free-plan d-flex align-items-center justify-content-between p-3 flex-column">
                    <div class="text-center">
                        @if (plan_data() ?? false)

                            <h3>
                                {{ plan_data()['plan']['subscriptionName'] ?? ''}}
                            </h3>
                            <h5>
                                {{ __('Expired') }}: {{ formatted_date(plan_data()['will_expire'] ?? '') }}
                            </h5>
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
</nav>
