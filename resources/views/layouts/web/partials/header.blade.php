<header class="header-section home-header">
    <nav class="navbar navbar-expand-lg p-0">
        <div class="container">
            <!-- Desktop Logo and Menu -->
            <a href="{{ route('home') }}" class="header-logo d-none d-lg-flex align-items-center"><img
                    src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                    alt="header-logo" /></a>

            <!-- Mobile Logo and Menu Toggle -->
            <a href="{{ route('home') }}" class="header-logo d-flex d-lg-none align-items-center"><img
                    src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                    alt="header-logo" /></a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"
                aria-controls="staticBackdrop">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>

            <a href="{{ Route::has($page_data['headings']['header_btn_link']) ? route($page_data['headings']['header_btn_link']) : route('login') }}"  class="get-app-btn login-btn ">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.48131 12.9012C4.30234 13.6032 1.21114 15.0366 3.09389 16.8304C4.01359 17.7065 5.03791 18.3332 6.32573 18.3332H13.6743C14.9621 18.3332 15.9864 17.7065 16.9061 16.8304C18.7888 15.0366 15.6977 13.6032 14.5187 12.9012C11.754 11.2549 8.24599 11.2549 5.48131 12.9012Z"
                        fill="white" />
                    <path
                        d="M13.75 5.4165C13.75 7.48757 12.0711 9.1665 10 9.1665C7.92893 9.1665 6.25 7.48757 6.25 5.4165C6.25 3.34544 7.92893 1.6665 10 1.6665C12.0711 1.6665 13.75 3.34544 13.75 5.4165Z"
                        fill="white" />
                </svg>
                {{ $page_data['headings']['header_btn_text'] ?? 'Login' }}
            </a>

            <!-- Mobile Menu -->
            <div class="offcanvas offcanvas-start mobile-menu" data-bs-backdrop="static" tabindex="-1"
                id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                <div class="offcanvas-header home-offcanvas-header">
                    <a href="{{ route('home') }}" class="header-logo d-flex align-items-center"><img
                            src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                            alt="header-logo" /></a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
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
                            <a href="javascript:void(0);" class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#support-menu" aria-expanded="false"
                                aria-controls="support-menu">{{ __('Pages') }}</a>
                            <div id="support-menu" class="accordion-collapse collapse"
                                data-bs-parent="#sidebarMenuAccordion">
                                <ul class="accordion-body p-0">
                                    <li>
                                        <a href="{{ route('blogs.index') }}">{{ __('Blog') }}</a>
                                        <p class="mb-0 arrow">></p>
                                    </li>
                                    <li>
                                        <a href="{{ route('term.index') }}"> {{ __('Terms & Conditions') }} </a>
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
                                    href="{{ route('term.index') }}">{{ __('Terms & Conditions') }}
                                    <span>></span></a>
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
                <a href="{{ Route::has($page_data['headings']['header_btn_link']) ? route($page_data['headings']['header_btn_link']) : route('login') }}"
                    class="get-app-btn">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.48131 12.9012C4.30234 13.6032 1.21114 15.0366 3.09389 16.8304C4.01359 17.7065 5.03791 18.3332 6.32573 18.3332H13.6743C14.9621 18.3332 15.9864 17.7065 16.9061 16.8304C18.7888 15.0366 15.6977 13.6032 14.5187 12.9012C11.754 11.2549 8.24599 11.2549 5.48131 12.9012Z"
                            fill="white" />
                        <path
                            d="M13.75 5.4165C13.75 7.48757 12.0711 9.1665 10 9.1665C7.92893 9.1665 6.25 7.48757 6.25 5.4165C6.25 3.34544 7.92893 1.6665 10 1.6665C12.0711 1.6665 13.75 3.34544 13.75 5.4165Z"
                            fill="white" />
                    </svg>

                    {{ $page_data['headings']['header_btn_text'] ?? 'Login' }}

                </a>
            </div>
        </div>
    </nav>
</header>

<style>
/* Velzon Header Styling using your original classes */

/* Header Section */
.header-section.home-header {
    position: relative;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    background: #fff;
    box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    transition: all 0.3s ease;
    padding: 0;
}

.header-section.home-header .navbar {
    min-height: 70px;
    padding: 0 !important;
}

.header-section.home-header .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    position: relative;
}

/* Logo Styling */
.header-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.header-logo img {
    max-height: 35px !important;
    width: auto !important;
    height: auto !important;
    transition: all 0.3s ease;
}

/* Navigation Links */
.navbar-nav .nav-link {
    color: #495057 !important;
    font-weight: 500;
    padding: 15px 20px !important;
    position: relative;
    transition: all 0.3s ease;
    text-decoration: none;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link:focus {
    color: #405189 !important;
}

.navbar-nav .nav-link.active {
    color: #405189 !important;
}

.navbar-nav .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 2px;
    background-color: #405189;
}

/* Dropdown Menu */
.menu-dropdown {
    position: relative;
}

.dropdown-content {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    min-width: 220px;
    box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.15);
    border-radius: 6px;
    padding: 8px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
    list-style: none;
    margin: 0;
    border: 1px solid #e9ecef;
}

.menu-dropdown:hover .dropdown-content {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-content li {
    margin: 0;
}

.dropdown-content .dropdown-item {
    color: #495057 !important;
    padding: 8px 20px !important;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
}

.dropdown-content .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #405189 !important;
}

.dropdown-content .dropdown-item span {
    color: #878a99;
    font-size: 12px;
}

/* Arrow for dropdown */
.nav-link .arrow {
    display: inline-block;
    margin-left: 8px;
    transition: transform 0.3s ease;
    color: #878a99;
}

.menu-dropdown:hover .nav-link .arrow {
    transform: rotate(90deg);
}

/* Mobile Toggle - Hidden by default */
.navbar-toggler {
    border: none;
    padding: 8px;
    background: none;
    color: #495057;
    font-size: 18px;
    display: none;
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* Get App Button - Desktop version visible by default */
.get-app-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #405189;
    color: #fff !important;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    font-size: 14px;
}

.get-app-btn:hover {
    background: #364574;
    color: #fff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(64, 81, 137, 0.3);
}

/* Hide mobile login button by default */
.get-app-btn.login-btn {
    display: none;
}

.get-app-btn svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

/* Mobile Menu */
.mobile-menu {
    max-width: 300px;
}

.home-offcanvas-header {
    padding: 24px;
    border-bottom: 1px solid #e9ecef;
}

.home-offcanvas-header .header-logo img {
    max-height: 30px !important;
}

.home-offcanvas-header .btn-close {
    background: none;
    border: none;
    font-size: 18px;
    color: #495057;
}

/* Mobile Accordion Menu */
.accordion-flush .accordion-item {
    border: none;
    border-bottom: 1px solid #f1f1f1;
}

.accordion-button.without-sub-menu,
.accordion-button {
    background: none;
    border: none;
    color: #495057;
    font-weight: 500;
    padding: 15px 24px;
    text-decoration: none;
    display: block;
    width: 100%;
    text-align: left;
    box-shadow: none;
}

.accordion-button.without-sub-menu:hover,
.accordion-button:hover {
    color: #405189;
    background: #f8f9fa;
}

.accordion-body {
    padding: 0;
}

.accordion-body ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.accordion-body li {
    border-bottom: 1px solid #f1f1f1;
}

.accordion-body li a {
    color: #495057;
    padding: 12px 24px 12px 40px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.accordion-body li a:hover {
    color: #405189;
    background: #f8f9fa;
}

.accordion-body .arrow {
    color: #878a99;
    font-size: 12px;
}

/* Desktop Layout */
@media (min-width: 992px) {
    .header-section.home-header .container {
        justify-content: space-between;
    }
    
    .header-logo {
        order: 1;
    }
    
    .navbar-collapse {
        order: 2;
        flex-grow: 1;
        justify-content: center;
        display: flex !important;
    }
    
    .get-app-btn:not(.login-btn) {
        order: 3;
        display: inline-flex !important;
    }
    
    .get-app-btn.login-btn {
        display: none !important;
    }
    
    .navbar-toggler {
        display: none !important;
    }
}

/* Tablet/Mobile Layout */
@media (max-width: 991.98px) {
    .header-logo img {
        max-height: 28px !important;
    }
    
    .navbar-collapse {
        display: none !important;
    }
    
    .get-app-btn:not(.login-btn) {
        display: none !important;
    }
    
    .get-app-btn.login-btn {
        display: inline-flex !important;
        order: 3;
    }
    
    .navbar-toggler {
        display: block !important;
        order: 1;
    }
    
    .header-logo {
        order: 2;
        flex-grow: 1;
        justify-content: center;
    }
    
    .container {
        display: flex !important;
        align-items: center;
    }
}

@media (max-width: 575.98px) {
    .header-section.home-header .container {
        padding: 0 15px;
    }
    
    .header-section.home-header .navbar {
        min-height: 60px;
    }
    
    .header-logo img {
        max-height: 25px !important;
    }
    
    .get-app-btn.login-btn {
        padding: 8px 12px;
        font-size: 13px;
    }
    
    .get-app-btn.login-btn svg {
        width: 14px;
        height: 14px;
    }
    
    .header-logo {
        justify-content: flex-start;
        margin-left: 15px;
    }
}

/* Scroll Effect */
.header-section.home-header.scrolled {
    box-shadow: 0 4px 12px rgba(15, 34, 58, 0.15);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Active navigation highlighting
    const currentLocation = location.pathname;
    const menuItems = document.querySelectorAll('.navbar-nav .nav-link');
    
    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentLocation) {
            item.classList.add('active');
        }
    });
    
    // Scroll effect for header
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header-section.home-header');
        if (window.scrollY > 10) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // Close mobile menu when clicking on a link
    const mobileLinks = document.querySelectorAll('.mobile-menu a');
    const offcanvas = document.getElementById('staticBackdrop');
    
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (!this.classList.contains('accordion-button') || this.classList.contains('without-sub-menu')) {
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
                if (bsOffcanvas) {
                    bsOffcanvas.hide();
                }
            }
        });
    });
});
</script>