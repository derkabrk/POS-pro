<link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_option('general')['favicon'] ?? 'assets/images/logo/favicon.png')}}">
<link rel="stylesheet" href="{{ asset('assets/web/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/web/css/swiper-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/web/fonts/fontawesome/css/all.min.css') }}" />
<!-- Slick Slider -->
<link rel="stylesheet" href="{{ asset('assets/web/css/slick.css') }}" />
{{-- jquery-confirm --}}
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/web/css/slick-theme.css') }}" />
<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('assets/web/css/styles.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/web/css/responsive.css') }}" />

<!-- Toaster -->
<link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

@if (app()->getLocale() == 'ar')
<link rel="stylesheet" href="{{ asset('assets/web/css/arabic.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
@endif

@stack('css')
