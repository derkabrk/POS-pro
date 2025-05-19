<header class="main-header-section sticky-top bg-white shadow-sm" id="page-topbar" style="z-index: 1030;">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- Left -->
                <button class="btn btn-outline-secondary border-0 sidebar-opner" style="font-size: 1.4rem;">
                    <i class="fal fa-bars"></i>
                </button>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <a href="{{ route('home') }}" target="_blank" class="text-decoration-none text-primary fw-semibold d-flex align-items-center gap-2">
                    <i class="fas fa-globe"></i> {{ __('View Website') }}
                </a>
            </div>

            <!-- Right -->
            <div class="d-flex align-items-center gap-4">
                <!-- Language Switch -->
                <div class="dropdown">
                    <button class="btn btn-light d-flex align-items-center gap-2 px-3 py-1 rounded-pill border" type="button" data-bs-toggle="dropdown">
                        <img src="{{ asset('flags/' . languages()[app()->getLocale()]['flag'] . '.svg') }}" alt="" style="width: 20px;">
                        {{ languages()[app()->getLocale()]['name'] }}
                        <i class="fas fa-chevron-down small"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        @foreach (languages() as $key => $language)
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ request()->fullUrlWithQuery(['lang' => $key]) }}">
                                    <img src="{{ asset('flags/' . $language['flag'] . '.svg') }}" style="width: 20px;">
                                    {{ $language['name'] }}
                                    @if (app()->getLocale() == $key)
                                        <i class="fas fa-check text-success ms-auto"></i>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Notifications -->
                @if(auth()->user()->role == 'superadmin')
                <div class="dropdown">
                    <a class="position-relative text-decoration-none" href="#" data-bs-toggle="dropdown">
                        <i class="far fa-bell fs-5 text-dark"></i>
                        @if(auth()->user()->unreadNotifications->count())
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill small">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-0 shadow-lg border-0" style="min-width: 320px; max-height: 400px; overflow-y: auto; border-radius: 8px;">
                        <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ __('Notifications') }}</span>
                            <a href="{{ route('admin.notifications.mtReadAll') }}" class="text-danger small">{{ __('Mark all read') }}</a>
                        </div>
                        <ul class="list-unstyled mb-0">
                            @forelse (auth()->user()->unreadNotifications as $notification)
                            <li class="px-3 py-2 border-bottom hover-bg">
                                <a href="{{ route('admin.notifications.mtView', $notification->id) }}" class="text-decoration-none d-block text-dark">
                                    <div class="d-flex justify-content-between">
                                        <span>{{ __($notification->data['message'] ?? '') }}</span>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <li class="px-3 py-3 text-muted text-center">{{ __('No new notifications') }}</li>
                            @endforelse
                        </ul>
                        <div class="px-3 py-2 text-end border-top">
                            <a href="{{ route('admin.notifications.index') }}" class="text-primary small">{{ __('View all') }}</a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Profile -->
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center text-decoration-none">
                        <img src="{{ asset(Auth::user()->image ?? 'assets/images/icons/default-user.png') }}" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;" alt="User">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a href="{{ url('cache-clear') }}" class="dropdown-item">
                                <i class="far fa-undo me-2 text-muted"></i> {{ __('Clear cache') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.profiles.index') }}" class="dropdown-item">
                                <i class="fal fa-user me-2 text-muted"></i> {{ __('My Profile') }}
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="dropdown-item logoutButton">
                                <i class="far fa-sign-out me-2 text-muted"></i> {{ __('Logout') }}
                                <form action="{{ route('logout') }}" method="post" id="logoutForm">@csrf</form>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

@push('styles')
<style>
    #page-topbar {
        z-index: 1030;
        background-color: #ffffff;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease-in-out;
    }

    .navbar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1.5rem;
        height: 70px;
    }

    .layout-width {
        width: 100%;
    }

    .header-item {
        height: 70px;
        display: flex;
        align-items: center;
    }

    .topnav-hamburger .hamburger-icon {
        width: 20px;
        height: 14px;
        position: relative;
        cursor: pointer;
        display: inline-block;
    }

    .topnav-hamburger .hamburger-icon span {
        position: absolute;
        height: 2px;
        width: 100%;
        background-color: #878a99;
        border-radius: 4px;
        transition: all 0.3s ease-in-out;
        left: 0;
    }

    .topnav-hamburger .hamburger-icon span:nth-child(1) {
        top: 0;
    }

    .topnav-hamburger .hamburger-icon span:nth-child(2) {
        top: 6px;
    }

    .topnav-hamburger .hamburger-icon span:nth-child(3) {
        top: 12px;
    }

    .btn-topbar {
        height: 42px;
        width: 42px;
        line-height: 42px;
    }

    .btn-ghost-secondary {
        color: #878a99;
        background-color: transparent;
    }

    .header-profile-user {
        height: 36px;
        width: 36px;
        background-color: #f3f3f9;
        padding: 1px;
    }

    .topbar-badge {
        right: 0;
        top: -2px;
        z-index: 1;
        font-size: 10px;
        padding: 0.25em 0.4em;
    }

    .topbar-user .dropdown-menu {
        animation: fadeIn 0.2s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush