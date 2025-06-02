<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid px-0">
            <div class="navbar-brand-box">
                <a href="{{ route('home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="" height="30">
                    </span>
                </a>
                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="" height="30">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" 
                    data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav mx-auto" id="topnav-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" data-key="t-home">
                            {{ __('Home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about.index') }}" data-key="t-about">
                            {{ __('About Us') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('plan.index') }}" data-key="t-pricing">
                            {{ __('Pricing') }}
                        </a>
                    </li>
                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="topnav-pages" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-key="t-pages">
                            {{ __('Pages') }} <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu mega-dropdown-menu px-2 p-3">
                            <div class="row">
                                <div class="col-lg-4">
                                    <ul class="list-unstyled mega-dropdown-list">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('blogs.index') }}" data-key="t-blog">
                                                {{ __('Blog') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('term.index') }}" data-key="t-terms">
                                                {{ __('Terms & Conditions') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('policy.index') }}" data-key="t-privacy">
                                                {{ __('Privacy Policy') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}" data-key="t-contact">
                            {{ __('Contact Us') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <a href="{{ Route::has($page_data['headings']['header_btn_link']) ? route($page_data['headings']['header_btn_link']) : route('login') }}" 
                   class="btn btn-primary">
                    <i class="ri-user-line align-middle me-1"></i>
                    {{ $page_data['headings']['header_btn_text'] ?? 'Login' }}
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header border-bottom">
            <a href="{{ route('home') }}" class="offcanvas-title" id="offcanvasNavbarLabel">
                <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="" height="25">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ri-home-4-line me-2"></i>
                        {{ __('Home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about.index') }}">
                        <i class="ri-information-line me-2"></i>
                        {{ __('About Us') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('plan.index') }}">
                        <i class="ri-price-tag-3-line me-2"></i>
                        {{ __('Pricing') }}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-pages-line me-2"></i>
                        {{ __('Pages') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('blogs.index') }}">
                                <i class="ri-article-line me-2"></i>
                                {{ __('Blog') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('term.index') }}">
                                <i class="ri-file-text-line me-2"></i>
                                {{ __('Terms & Conditions') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('policy.index') }}">
                                <i class="ri-shield-line me-2"></i>
                                {{ __('Privacy Policy') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.index') }}">
                        <i class="ri-contacts-line me-2"></i>
                        {{ __('Contact Us') }}
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a href="{{ Route::has($page_data['headings']['header_btn_link']) ? route($page_data['headings']['header_btn_link']) : route('login') }}" 
                       class="btn btn-primary w-100">
                        <i class="ri-user-line me-1"></i>
                        {{ $page_data['headings']['header_btn_text'] ?? 'Login' }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

