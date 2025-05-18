<header class="main-header-section sticky-top bg-white shadow-sm px-4 py-2" style="z-index: 1030;">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Left -->
        <div class="d-flex align-items-center gap-3">
        
               <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger sidebar-opner" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>            <a href="{{ route('home') }}" target="_blank" class="text-decoration-none text-primary fw-semibold d-flex align-items-center gap-2">
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
</header>
<style>
.hover-bg:hover {
    background-color: #f9f9f9;
}
</style>
@push('styles')
<style>
    .main-header-section {
        transition: all 0.3s ease-in-out;
        border-bottom: 1px solid #e9ecef;
    }

    .sidebar-opner {
        font-size: 1.4rem;
        color: #555;
    }

    .sidebar-opner:hover {
        color: #007bff;
    }

    .flag-icon {
        width: 20px;
        height: 14px;
        object-fit: contain;
    }

    .dropdown-menu {
        border-radius: 0.5rem;
        font-size: 0.875rem;
    }

    .dropdown-item:active,
    .dropdown-item:hover {
        background-color: #f0f4f8;
        color: #000;
    }

    .hover-bg:hover {
        background-color: #f8f9fa;
    }

    .notifications .badge {
        font-size: 0.65rem;
        padding: 0.25em 0.4em;
        border-radius: 50%;
    }

    .profile-info img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
    }

    .dropdown-toggle:after {
        display: none;
    }

    .btn-light {
        background-color: #f9f9f9;
        border: 1px solid #e0e0e0;
        color: #333;
    }

    .btn-light:hover {
        background-color: #f1f1f1;
    }

    .dropdown-menu {
    animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>
@endpush
