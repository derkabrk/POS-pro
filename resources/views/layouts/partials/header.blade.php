<header class="main-header-section sticky-top bg-white shadow-sm py-2 px-4" style="z-index: 1030;">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Left Side -->
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-md-none border-0 sidebar-opner" style="font-size: 1.3rem;">
                <i class="fal fa-bars"></i>
            </button>
            <a href="{{ route('home') }}" target="_blank" class="text-decoration-none text-primary fw-semibold d-flex align-items-center gap-2">
                <i class="fas fa-globe"></i> {{ __('View Website') }}
            </a>
        </div>

        <!-- Middle (optional spacing or logo) -->
        <div class="d-none d-md-block"></div>

        <!-- Right Side -->
        <div class="d-flex align-items-center gap-3">
            <!-- Language Selector -->
            <div class="dropdown">
                <button class="btn btn-light d-flex align-items-center gap-2 rounded-pill px-3 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('flags/' . languages()[app()->getLocale()]['flag'] . '.svg') }}" alt="" class="flag-icon" style="width: 20px;">
                    {{ languages()[app()->getLocale()]['name'] }}
                    <i class="fas fa-chevron-down small ms-1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    @foreach (languages() as $key => $language)
                        <li class="px-2">
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ request()->fullUrlWithQuery(['lang' => $key]) }}">
                                <img src="{{ asset('flags/' . $language['flag'] . '.svg') }}" class="flag-icon" style="width: 20px;">
                                {{ $language['name'] }}
                                @if (app()->getLocale() == $key)
                                    <i class="fas fa-check ms-auto text-success"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Notifications (Only for Superadmin) -->
            @if (auth()->user()->role == 'superadmin')
                <div class="dropdown">
                    <a class="position-relative" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/images/icons/bel.svg') }}" alt="Notifications" style="width: 24px;">
                        @if(auth()->user()->unreadNotifications->count())
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger small">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-3 shadow-sm" style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <p class="mb-0 text-sm">
                                {{ __('You Have') }} <strong>{{ auth()->user()->unreadNotifications->count() }}</strong> {{ __('new Notifications') }}
                            </p>
                            <a href="{{ route('admin.notifications.mtReadAll') }}" class="text-danger small">{{ __('Mark all Read') }}</a>
                        </div>
                        <ul class="list-unstyled mb-0">
                            @forelse (auth()->user()->unreadNotifications as $notification)
                                <li class="mb-2">
                                    <a href="{{ route('admin.notifications.mtView', $notification->id) }}" class="text-dark text-decoration-none d-block">
                                        <div class="fw-semibold">{{ __($notification->data['message'] ?? '') }}</div>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                            @empty
                                <li class="text-muted">{{ __('No notifications') }}</li>
                            @endforelse
                        </ul>
                        <hr class="my-2">
                        <div class="text-end">
                            <a class="text-primary small" href="{{ route('admin.notifications.index') }}">{{ __('View all notifications') }}</a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center">
                    <img src="{{ asset(Auth::user()->image ?? 'assets/images/icons/default-user.png') }}" alt="Profile" class="rounded-circle" style="width: 34px; height: 34px; object-fit: cover;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a href="{{ url('cache-clear') }}" class="dropdown-item">
                            <i class="far fa-undo me-2"></i> {{ __('Clear cache') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.profiles.index') }}" class="dropdown-item">
                            <i class="fal fa-user me-2"></i> {{ __('My Profile') }}
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="dropdown-item logoutButton">
                            <i class="far fa-sign-out me-2"></i> {{ __('Logout') }}
                            <form action="{{ route('logout') }}" method="post" id="logoutForm">@csrf</form>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
