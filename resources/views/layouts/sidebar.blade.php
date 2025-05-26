<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="37">
            </span>
            <span class="logo-lg">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="37">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="37">
            </span>
            <span class="logo-lg">
                <img src="{{ asset(get_option('general')['admin_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="37">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                
                @can('dashboard-read')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.dashboard.index') ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @endcan

                @can('banners-read')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.banners.index', 'admin.banners.create', 'admin.banners.edit') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                        <i class="ri-advertisement-line"></i> <span>{{ __('Advertising') }}</span>
                    </a>
                </li>
                @endcan

                @canany(['business-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.business.index','admin.business.create','admin.business.edit') ? 'active' : '' }}" href="{{ route('admin.business.index') }}">
                        <i class="ri-store-2-line"></i> <span>{{ __('Business List') }}</span>
                    </a>
                </li>
                @endcanany

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.dynamicApiHeader.index','admin.dynamicApiHeader.create','admin.dynamicApiHeader.edit') ? 'active' : '' }}" href="{{ route('admin.dynamicApiHeader.index') }}">
                        <i class="ri-code-line"></i> <span>{{ __('Dynamic API Headers') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTicketSystem" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Request::routeIs('admin.ticketSystem.index', 'admin.ticketSystem.categories') ? 'true' : 'false' }}"
                        aria-controls="sidebarTicketSystem">
                        <i class="ri-ticket-line"></i> <span>{{ __('Ticket System') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.ticketSystem.index', 'admin.ticketSystem.categories') ? 'show' : '' }}" id="sidebarTicketSystem">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.ticketSystem.index') }}" class="nav-link {{ Request::routeIs('admin.ticketSystem.index') ? 'active' : '' }}">{{ __('Manage Ticket') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ticketSystem.categories') }}" class="nav-link {{ Request::routeIs('admin.ticketSystem.categories') ? 'active' : '' }}">{{ __('Manage Categories') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>

                @canany(['business-categories-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.business-categories.index','admin.business-categories.create','admin.business-categories.edit') ? 'active' : '' }}" href="{{ route('admin.business-categories.index') }}">
                        <i class="ri-folders-line"></i> <span>{{ __('Business Category') }}</span>
                    </a>
                </li>
                @endcanany
                
                @canany(['shipping-companies-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.shipping-companies.index','admin.shipping-companies.create','admin.shipping-companies.edit') ? 'active' : '' }}" href="{{ route('admin.shipping-companies.index') }}">
                        <i class="ri-truck-line"></i> <span>{{ __('Shipping-Companies') }}</span>
                    </a>
                </li>
                @endcanany

                @canany(['plans-read', 'plans-create'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPlans" data-bs-toggle="collapse" role="button" 
                        aria-expanded="{{ Route::is('admin.plans.index', 'admin.plans.create', 'admin.plans.edit') ? 'true' : 'false' }}" 
                        aria-controls="sidebarPlans">
                        <i class="ri-rocket-line"></i> <span>{{ __('Subscription Plans') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.plans.index', 'admin.plans.create', 'admin.plans.edit') ? 'show' : '' }}" id="sidebarPlans">
                        <ul class="nav nav-sm flex-column">
                            @can('plans-create')
                            <li class="nav-item">
                                <a href="{{ route('admin.plans.create') }}" class="nav-link {{ Route::is('admin.plans.create') ? 'active' : '' }}">{{ __('Create Plan') }}</a>
                            </li>
                            @endcan
                            @can('plans-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.plans.index') }}" class="nav-link {{ Route::is('admin.plans.index', 'admin.plans.edit') ? 'active' : '' }}">{{ __('Manage Plans') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['users-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button" 
                        aria-expanded="{{ Request::routeIs('admin.users.index', 'admin.users.create', 'admin.users.edit') ? 'true' : 'false' }}" 
                        aria-controls="sidebarUsers">
                        <i class="ri-user-line"></i> <span>{{ __('Staff Management') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.users.index', 'admin.users.create', 'admin.users.edit') ? 'show' : '' }}" id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.create') }}" class="nav-link {{ Request::routeIs('admin.users.create') ? 'active' : '' }}">{{ __('Create Staff') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::routeIs('admin.users.index', 'admin.users.edit') ? 'active' : '' }}">{{ __('Manage Staff') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['subscription-reports-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarReports" data-bs-toggle="collapse" role="button" 
                        aria-expanded="{{ Route::is('admin.subscription-reports.index') ? 'true' : 'false' }}" 
                        aria-controls="sidebarReports">
                        <i class="ri-file-chart-line"></i> <span>{{ __('Reports') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Route::is('admin.subscription-reports.index') ? 'show' : '' }}" id="sidebarReports">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.subscription-reports.index') }}" class="nav-link {{ Route::is('admin.subscription-reports.index') ? 'active' : '' }}">{{ __('Subscription Reports') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['messages-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMessages" data-bs-toggle="collapse" role="button" 
                        aria-expanded="{{ Request::routeIs('admin.messages.index', 'admin.messages.create', 'admin.messages.edit') ? 'true' : 'false' }}" 
                        aria-controls="sidebarMessages">
                        <i class="ri-message-2-line"></i> <span>{{ __('Messages') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.messages.index', 'admin.messages.create', 'admin.messages.edit') ? 'show' : '' }}" id="sidebarMessages">
                        <ul class="nav nav-sm flex-column">
                            @can('messages-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.messages.index') }}" class="nav-link {{ Request::routeIs('admin.messages.index') ? 'active' : '' }}">{{ __('Contact Messages') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('chat.index') ? 'active' : '' }}" href="{{ route('chat.index') }}">
                        <i class="ri-chat-1-line"></i> <span>{{ __('Chat') }}</span>
                    </a>
                </li>

                @canany(['settings-read', 'notifications-read', 'currencies-read', 'sms-read', 'features-read',
                'blogs-read', 'newsletters-read', 'interfaces-read', 'designs-read', 'testimonials-read', 'terms-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCMS" data-bs-toggle="collapse" role="button" 
                        aria-expanded="{{ Request::routeIs('admin.website-settings.index', 'admin.faqs.create', 'admin.faqs.destroy', 'admin.faqs.edit', 'admin.faqs.index', 'admin.testimonials.index', 'admin.testimonials.create', 'admin.testimonials.edit', 'admin.features.index', 'admin.features.create', 'admin.features.edit', 'admin.blogs.index', 'admin.blogs.create', 'admin.blogs.edit', 'admin.blogs.filter.comment', 'admin.newsletters.index', 'admin.interfaces.index', 'admin.interfaces.create', 'admin.interfaces.edit', 'admin.designs.index', 'admin.designs.create', 'admin.designs.edit', 'admin.testimonials.index', 'admin.testimonials.create', 'admin.testimonials.edit', 'admin.term-conditions.index', 'admin.privacy-policy.index') ? 'true' : 'false' }}" 
                        aria-controls="sidebarCMS">
                        <i class="ri-pages-line"></i> <span>{{ __('CMS Manage') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.website-settings.index', 'admin.faqs.create', 'admin.faqs.destroy', 'admin.faqs.edit', 'admin.faqs.index', 'admin.testimonials.index', 'admin.testimonials.create', 'admin.testimonials.edit', 'admin.features.index', 'admin.features.create', 'admin.features.edit', 'admin.blogs.index', 'admin.blogs.create', 'admin.blogs.edit', 'admin.blogs.filter.comment', 'admin.newsletters.index', 'admin.interfaces.index', 'admin.interfaces.create', 'admin.interfaces.edit', 'admin.designs.index', 'admin.designs.create', 'admin.designs.edit', 'admin.testimonials.index', 'admin.testimonials.create', 'admin.testimonials.edit', 'admin.term-conditions.index', 'admin.privacy-policy.index') ? 'show' : '' }}" id="sidebarCMS">
                        <ul class="nav nav-sm flex-column">
                            @can('settings-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.website-settings.index') }}" class="nav-link {{ Request::routeIs('admin.website-settings.index') ? 'active' : '' }}">{{ __('Manage Pages') }}</a>
                            </li>
                            @endcan
                            
                            @can('faqs-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ Request::routeIs('admin.faqs.create', 'admin.faqs.destroy', 'admin.faqs.edit', 'admin.faqs.index') ? 'active' : '' }}">{{ __('Manage FAQs') }}</a>
                            </li>
                            @endcan
                            
                            <li class="nav-item">
                                <a href="{{ route('admin.term-conditions.index') }}" class="nav-link {{ Request::routeIs('admin.term-conditions.index') ? 'active' : '' }}">{{ __('Terms & Conditions') }}</a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('admin.privacy-policy.index') }}" class="nav-link {{ Request::routeIs('admin.privacy-policy.index') ? 'active' : '' }}">{{ __('Privacy & Policy') }}</a>
                            </li>
                            
                            @can('testimonials-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ Request::routeIs('admin.testimonials.index', 'admin.testimonials.create', 'admin.testimonials.edit') ? 'active' : '' }}">{{ __('Testimonials') }}</a>
                            </li>
                            @endcan
                            
                            @can('features-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.features.index') }}" class="nav-link {{ Request::routeIs('admin.features.index', 'admin.features.create', 'admin.features.edit') ? 'active' : '' }}">{{ __('Features') }}</a>
                            </li>
                            @endcan
                            
                            @can('interfaces-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.interfaces.index') }}" class="nav-link {{ Request::routeIs('admin.interfaces.index', 'admin.interfaces.create', 'admin.interfaces.edit') ? 'active' : '' }}">{{ __('Interface') }}</a>
                            </li>
                            @endcan
                            
                            @can('blogs-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ Request::routeIs('admin.blogs.index', 'admin.blogs.create', 'admin.blogs.edit', 'admin.blogs.filter.comment') ? 'active' : '' }}">{{ __('Manage Blogs') }}</a>
                            </li>
                            @endcan
                            
                            @can('newsletters-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.newsletters.index') }}" class="nav-link {{ Request::routeIs('admin.newsletters.index') ? 'active' : '' }}">{{ __('Newsletters') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                @canany(['roles-read', 'permissions-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRoles" data-bs-toggle="collapse" role="button" 
                        aria-expanded="{{ Request::routeIs('admin.roles.index', 'admin.roles.create', 'admin.roles.edit', 'admin.permissions.index') ? 'true' : 'false' }}" 
                        aria-controls="sidebarRoles">
                        <i class="ri-shield-user-line"></i> <span>{{ __('Roles & Permissions') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.roles.index', 'admin.roles.create', 'admin.roles.edit', 'admin.permissions.index') ? 'show' : '' }}" id="sidebarRoles">
                        <ul class="nav nav-sm flex-column">
                            @can('roles-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link {{ Request::routeIs('admin.roles.index', 'admin.roles.create', 'admin.roles.edit') ? 'active' : '' }}">{{ __('Roles') }}</a>
                            </li>
                            @endcan
                            
                            @can('permissions-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ Request::routeIs('admin.permissions.index') ? 'active' : '' }}">{{ __('Permissions') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.addons.index') ? 'active' : '' }}" href="{{ route('admin.addons.index') }}">
                        <i class="ri-puzzle-line"></i> <span>{{ __('Addons') }}</span>
                    </a>
                </li>

                @canany(['settings-read', 'notifications-read', 'currencies-read', 'gateways-read'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button" 
                        aria-expanded="{{ Request::routeIs('admin.settings.index', 'admin.notifications.index', 'admin.system-settings.index', 'admin.currencies.index', 'admin.currencies.create', 'admin.currencies.edit', 'admin.gateways.index') ? 'true' : 'false' }}" 
                        aria-controls="sidebarSettings">
                        <i class="ri-settings-3-line"></i> <span>{{ __('Settings') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.settings.index', 'admin.notifications.index', 'admin.system-settings.index', 'admin.currencies.index', 'admin.currencies.create', 'admin.currencies.edit', 'admin.gateways.index') ? 'show' : '' }}" id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            @can('currencies-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.currencies.index') }}" class="nav-link {{ Request::routeIs('admin.currencies.index', 'admin.currencies.create', 'admin.currencies.edit') ? 'active' : '' }}">{{ __('Currencies') }}</a>
                            </li>
                            @endcan
                            
                            @can('notifications-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ Request::routeIs('admin.notifications.index') ? 'active' : '' }}">{{ __('Notifications') }}</a>
                            </li>
                            @endcan
                            
                            @can('gateways-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.gateways.index') }}" class="nav-link {{ Request::routeIs('admin.gateways.index') ? 'active' : '' }}">{{ __('Payment Gateway') }}</a>
                            </li>
                            @endcan
                            
                            @can('settings-read')
                            <li class="nav-item">
                                <a href="{{ route('admin.system-settings.index') }}" class="nav-link {{ Request::routeIs('admin.system-settings.index') ? 'active' : '' }}">{{ __('System Settings') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ Request::routeIs('admin.settings.index') ? 'active' : '' }}">{{ __('General Settings') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
