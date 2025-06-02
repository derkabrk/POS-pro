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

<style>
/* Velzon Header Styling */
#page-topbar {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1002;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    transition: all 0.3s ease;
}

.navbar-header {
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0 calc(24px / 2);
    min-height: 70px;
}

.navbar-brand-box {
    width: 250px;
    text-align: center;
    padding: 0 24px;
}

.logo {
    line-height: 70px;
}

.logo img {
    max-height: 30px !important;
    width: auto !important;
}

.logo-sm {
    display: none;
}

.logo-lg {
    display: inline-block;
}

/* Navigation Styling */
.navbar-nav .nav-link {
    color: #495057;
    font-weight: 500;
    padding: 15px 20px;
    position: relative;
    transition: all 0.3s ease;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link:focus {
    color: #405189;
}

.navbar-nav .nav-link.active {
    color: #405189;
}

/* Dropdown Styling */
.dropdown-menu {
    border: 1px solid #e9ecef;
    box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.15);
    border-radius: 6px;
    margin-top: 5px;
}

.dropdown-item {
    padding: 8px 20px;
    color: #495057;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #405189;
}

/* Mobile Menu Button */
.topnav-hamburger {
    display: none;
    background: none;
    border: none;
    padding: 0;
    width: 18px;
    height: 18px;
    position: relative;
}

.topnav-hamburger span {
    display: block;
    height: 2px;
    width: 100%;
    background: #495057;
    margin: 3px 0;
    transition: 0.3s;
}

/* Mobile Offcanvas */
.offcanvas-header {
    padding: 1.5rem;
}

.offcanvas-body .nav-link {
    padding: 12px 0;
    border-bottom: 1px solid #f1f1f1;
}

.offcanvas-body .nav-link i {
    width: 20px;
    color: #878a99;
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .navbar-brand-box {
        width: auto;
        text-align: left;
        padding: 0;
    }
    
    .logo-lg {
        display: none;
    }
    
    .logo-sm {
        display: inline-block;
    }
    
    .topnav-hamburger {
        display: block;
    }
    
    .collapse.navbar-collapse {
        display: none !important;
    }
    
    #page-topbar .d-flex {
        gap: 15px;
    }
}

@media (max-width: 575.98px) {
    .navbar-header {
        padding: 0 15px;
        min-height: 60px;
    }
    
    .logo {
        line-height: 60px;
    }
    
    .logo img {
        max-height: 22px !important;
    }
}

/* Button Styling */
.btn-primary {
    background-color: #405189;
    border-color: #405189;
    font-weight: 500;
    padding: 8px 20px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #364574;
    border-color: #364574;
    transform: translateY(-1px);
}

/* Arrow Down for Dropdown */
.arrow-down {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 8px;
    vertical-align: middle;
    border-top: 4px solid;
    border-right: 4px solid transparent;
    border-bottom: 0;
    border-left: 4px solid transparent;
}

/* Active Page Indicator */
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const hamburger = document.querySelector('.topnav-hamburger');
    const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasNavbar'));
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            offcanvas.toggle();
        });
    }
    
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
        const header = document.getElementById('page-topbar');
        if (window.scrollY > 10) {
            header.style.boxShadow = '0 4px 12px rgba(15, 34, 58, 0.15)';
        } else {
            header.style.boxShadow = '0 2px 4px rgba(15, 34, 58, 0.12)';
        }
    });
});
</script>