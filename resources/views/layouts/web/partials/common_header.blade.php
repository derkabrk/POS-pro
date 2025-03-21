<header class="header-section">
    <nav class="navbar navbar-expand-lg p-0">
        <div class="container">
            <a href="{{ route('home') }}" class="header-logo">
                <img src="{{ asset($general->value['common_header_logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                    alt="header-logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
                aria-controls="staticBackdrop">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Mobile Menu -->
            <div href="javascript:void(0);" class="offcanvas offcanvas-start mobile-menu" data-bs-backdrop="static"
                tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                <div class="offcanvas-header">
                    <a href="{{ route('home') }}" class="header-logo"><img
                            src="{{ asset($general->value['common_header_logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                            alt="header-logo" /></a>
                    <button type="button" class="btn-close btn-close-commmon" data-bs-dismiss="offcanvas"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="offcanvas-body">
                    <div class="accordion accordion-flush mb-30" id="sidebarMenuAccordion">
                        <div class="accordion-item">
                            <a href="{{ route('home') }}" class="accordion-button without-sub-menu"
                                type="button">{{ __('Home') }}</a>
                        </div>
                        <div class="accordion-item">
                            <a href="{{ route('about.index') }}" class="accordion-button without-sub-menu"
                                type="button">{{ __('About Us') }}</a>
                        </div>

                        <div class="accordion-item">
                            <a href="{{ route('plan.index') }}" class="accordion-button without-sub-menu"
                                type="button">{{ __('Pricing') }}</a>
                        </div>

                        <div class="accordion-item">
                            <a href="" class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#support-menu" aria-expanded="false"
                                aria-controls="support-menu">{{ __('Pages') }}</a>
                            <div id="support-menu" class="accordion-collapse collapse"
                                data-bs-parent="#sidebarMenuAccordion">
                                <ul class="accordion-body p-0">
                                    <li>
                                        <a href="{{ route('blogs.index') }}"> {{ __('Blog') }}</a>
                                        <p class="mb-0 arrow">></p>
                                    </li>
                                    <li>
                                        <a href="{{ route('term.index') }}">{{ __('Terms & Conditions') }}</a>
                                        <p class="mb-0 arrow">></p>
                                    </li>
                                    <li>
                                        <a href="{{ route('policy.index') }}"> {{ __('Privacy Policy') }} </a>
                                        <p class="mb-0 arrow">></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <a href="{{ route('contact.index') }}" class="accordion-button without-sub-menu"
                                type="button">{{ __('Contact Us') }}</a>
                        </div>
                    </div>

                    <a href="{{ $page_data['headings']['header_btn_link'] ?? '' }}" class="get-app-btn">
                        {{ $page_data['headings']['header_btn_text'] ?? '' }}
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <!-- Desktop Menu -->
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link active"
                            aria-current="page">{{ __('Home') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page"
                            href="{{ route('about.index') }}">{{ __('About Us') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page"
                            href="{{ route('plan.index') }}">{{ __('Pricing') }}</a>
                    </li>

                    <li class="nav-item menu-dropdown">
                        <a class="nav-link" aria-current="page" href="javascript:void(0);">{{ __('Pages') }} <span
                                class="arrow">></span></a>
                        <ul class="dropdown-content">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('blogs.index') }}">{{ __('Blog') }}<span>></span></a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('term.index') }}">{{ __('Terms & Conditions') }} <span>></span></a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('policy.index') }}">{{ __('Privacy Policy') }}<span>></span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page"
                            href="{{ route('contact.index') }}">{{ __('Contact Us') }}</a>
                    </li>
                </ul>

                <a href="{{ $page_data['headings']['header_btn_link'] ?? '' }}" class="get-app-btn">
                    {{ $page_data['headings']['header_btn_text'] ?? '' }}
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </nav>
</header>
