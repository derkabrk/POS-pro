{{-- common_header.blade.php (for other pages - !request()->is('/')) --}}
<div class="layout-wrapper">
    <nav class="navbar navbar-expand-lg navbar-landing" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" 
                     class="card-logo card-logo-dark" alt="logo dark" height="17">
                <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" 
                     class="card-logo card-logo-light" alt="logo light" height="17">
            </a>
            
            <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}" 
                           href="{{ route('about.index') }}">{{ __('About Us') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('plan.*') ? 'active' : '' }}" 
                           href="{{ route('plan.index') }}">{{ __('Pricing') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Pages') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('blogs.*') ? 'active' : '' }}" 
                                   href="{{ route('blogs.index') }}">{{ __('Blog') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('term.*') ? 'active' : '' }}" 
                                   href="{{ route('term.index') }}">{{ __('Terms & Conditions') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('policy.*') ? 'active' : '' }}" 
                                   href="{{ route('policy.index') }}">{{ __('Privacy Policy') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" 
                           href="{{ route('contact.index') }}">{{ __('Contact Us') }}</a>
                    </li>
                </ul>

                <div class="">
                    <a href="{{ Route::has($page_data['headings']['header_btn_link']) ? route($page_data['headings']['header_btn_link']) : route('login') }}" 
                       class="btn btn-link fw-medium text-decoration-none text-dark">Sign in</a>
                    <a href="{{ Route::has($page_data['headings']['header_btn_link']) ? route($page_data['headings']['header_btn_link']) : route('login') }}" 
                       class="btn btn-primary">{{ $page_data['headings']['header_btn_text'] ?? 'Sign Up' }}</a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Menu Overlay -->
    <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent.show"></div>
</div>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start mobile-menu" data-bs-backdrop="static" tabindex="-1" 
     id="staticBackdrop" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header home-offcanvas-header">
        <a href="{{ route('home') }}" class="header-logo">
            <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" 
                 alt="header-logo" />
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion accordion-flush mb-30" id="sidebarMenuAccordion">
            <div class="accordion-item">
                <a href="{{ route('home') }}" 
                   class="accordion-button without-sub-menu {{ request()->routeIs('home') ? 'active' : '' }}" 
                   type="button">
                    {{ __('Home') }}
                </a>
            </div>
            <div class="accordion-item">
                <a href="{{ route('about.index') }}" 
                   class="accordion-button without-sub-menu {{ request()->routeIs('about.*') ? 'active' : '' }}" 
                   type="button">
                    {{ __('About Us') }}
                </a>
            </div>
            <div class="accordion-item">
                <a href="{{ route('plan.index') }}" 
                   class="accordion-button without-sub-menu {{ request()->routeIs('plan.*') ? 'active' : '' }}" 
                   type="button">
                    {{ __('Pricing') }}
                </a>
            </div>
            <div class="accordion-item">
                <a href="javascript:void(0);" class="accordion-button collapsed" type="button"
                   data-bs-toggle="collapse" data-bs-target="#support-menu" aria-expanded="false"
                   aria-controls="support-menu">{{ __('Pages') }}</a>
                <div id="support-menu" class="accordion-collapse collapse"
                     data-bs-parent="#sidebarMenuAccordion">
                    <ul class="accordion-body p-0">
                        <li>
                            <a href="{{ route('blogs.index') }}" 
                               class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">{{ __('Blog') }}</a>
                            <p class="mb-0 arrow">></p>
                        </li>
                        <li>
                            <a href="{{ route('term.index') }}" 
                               class="{{ request()->routeIs('term.*') ? 'active' : '' }}">{{ __('Terms & Conditions') }}</a>
                            <p class="mb-0 arrow">></p>
                        </li>
                        <li>
                            <a href="{{ route('policy.index') }}" 
                               class="{{ request()->routeIs('policy.*') ? 'active' : '' }}">{{ __('Privacy Policy') }}</a>
                            <p class="mb-0 arrow">></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="accordion-item">
                <a href="{{ route('contact.index') }}" 
                   class="accordion-button without-sub-menu {{ request()->routeIs('contact.*') ? 'active' : '' }}" 
                   type="button">
                    {{ __('Contact Us') }}
                </a>
            </div>
        </div>
    </div>
</div>