<header class="main-header-section sticky-top">
    <div class="header-wrapper">
        <div class="header-left">
            <div class="sidebar-opner menu-opener"><i class="fal fa-bars" aria-hidden="true"></i></div>
            <a target="_blank" class="text-custom-primary view-website" href="{{ route('home') }}">
                {{ __('View Website') }}
                <i class="fas fa-chevron-double-right"></i>
            </a>

            <a class="pos-logo" href="javascript:void(0)"><img src="{{ asset(get_option('general')['common_header_logo'] ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo"></a>
           
        </div>
        <div class="header-middle"></div>
        <div class="header-right">
            <div class="language-change">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('flags/' . languages()[app()->getLocale()]['flag'] . '.svg') }}"
                            alt="" class="flag-icon me-2">
                        {{ languages()[app()->getLocale()]['name'] }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-scroll">
                        @foreach (languages() as $key => $language)
                            <li class="language-li">
                                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['lang' => $key]) }}">
                                    <img src="{{ asset('flags/' . $language['flag'] . '.svg') }}" alt=""
                                        class="flag-icon me-2">
                                    {{ $language['name'] }}
                                </a>
                                @if (app()->getLocale() == $key)
                                    <i class="fas fa-check language-check"></i>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="notifications dropdown">
                <a href="#" class="dropdown-toggleer mt-1 me-2" data-bs-toggle="dropdown">
                    <i><img src="{{ asset('assets/images/icons/bel.svg') }}" alt=""></i>
                    <span class="bg-red">{{ auth()->user()->unreadNotifications->count() }}</span>
                </a>
                <div class="dropdown-menu notification-container">
                    <div class="notification-header ">
                        <a href="{{ route('business.notifications.mtReadAll') }}"
                            class="text-red">{{ __('Mark all Read') }}</a>
                    </div>
                    <ul>
                        @foreach (auth()->user()->unreadNotifications  as $notification)
                            <li>
                                <a href="{{ route('business.notifications.mtView', $notification->id) }}">
                                    <strong>{{ __($notification->data['message'] ?? '') }}</strong>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="notification-footer">
                        <a class="text-red"
                            href="{{ route('business.notifications.index') }}">{{ __('View all notifications') }}</a>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <div class="profile-info dropdown">
                    <a href="#" data-bs-toggle="dropdown">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="greet-name">
                                <p class="nav-greeting">Hello🖐</p>
                                <h6 class="nav-name">{{ Auth::user()->name }}</h6>
                            </div>
                            <img src="{{ asset(Auth::user()->image ?? 'assets/images/icons/default-user.png') }}"
                                alt="Profile">
                        </div>
                    </a>
                    <div class=" business-profile bg-success">

                        <ul class="dropdown-menu">
                            <li> <a href="{{ route('business.profiles.index') }}"> <i class="fal fa-user"></i>
                                    {{ __('My Profile') }}</a></li>
                            <li>
                                <a href="javascript:void(0)" class="logoutButton">
                                    <i class="far fa-sign-out"></i> {{ __('Logout') }}
                                    <form action="{{ route('logout') }}" method="post" id="logoutForm">
                                        @csrf
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="sidebar-opner menu-openerr"><i class="fal fa-bars" aria-hidden="true"></i></div>

            </div>
        </div>
    </div>
</header>
