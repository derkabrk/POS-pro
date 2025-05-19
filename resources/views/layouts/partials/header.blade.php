<header id="page-topbar" class="sticky-top">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- Left -->
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm px-3 header-item">
                    <i class="fas fa-globe fs-16"></i> {{ __('View Website') }}
                </a>
            </div>

            <!-- Right -->
            <div class="d-flex align-items-center">
                <!-- Language Switch -->
                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('flags/' . languages()[app()->getLocale()]['flag'] . '.svg') }}" class="rounded" alt="Header Language" height="20">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach (languages() as $key => $language)
                            <a href="{{ request()->fullUrlWithQuery(['lang' => $key]) }}" class="dropdown-item notify-item language" data-lang="{{ $key }}">
                                <img src="{{ asset('flags/' . $language['flag'] . '.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                <span class="align-middle">{{ $language['name'] }}</span>
                                @if (app()->getLocale() == $key)
                                    <i class="fas fa-check text-success ms-auto"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Notifications -->
                @if(auth()->user()->role == 'superadmin')
                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-bell fs-22"></i>
                        @if(auth()->user()->unreadNotifications->count())
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ auth()->user()->unreadNotifications->count() }}<span class="visually-hidden">unread messages</span></span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">{{ __('Notifications') }}</h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <a href="{{ route('admin.notifications.mtReadAll') }}" class="badge bg-light-subtle text-body fs-13">{{ __('Mark all read') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 300px;">
                            <div class="tab-content position-relative">
                                <div class="tab-pane fade show active py-2 ps-2">
                                    @forelse (auth()->user()->unreadNotifications as $notification)
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <a href="{{ route('admin.notifications.mtView', $notification->id) }}" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">{{ __($notification->data['message'] ?? '') }}</h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center p-3">
                                        <h5 class="m-0">{{ __('No new notifications') }}</h5>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="p-2 border-top">
                            <div class="text-center pt-1">
                                <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary btn-sm">{{ __('View all') }} <i class="ri-arrow-right-line align-middle"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Profile -->
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ asset(Auth::user()->image ?? 'assets/images/icons/default-user.png') }}" alt="User">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">{{Auth::user()->name}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ __('Admin') }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ url('cache-clear') }}" class="dropdown-item"><i class="mdi mdi-reload text-muted fs-16 align-middle me-1"></i> <span class="align-middle">{{ __('Clear cache') }}</span></a>
                        <a href="{{ route('admin.profiles.index') }}" class="dropdown-item"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">{{ __('My Profile') }}</span></a>
                        <a href="javascript:void(0)" class="dropdown-item logoutButton"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle">{{ __('Logout') }}</span>
                            <form action="{{ route('logout') }}" method="post" id="logoutForm">@csrf</form>
                        </a>
                    </div>
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