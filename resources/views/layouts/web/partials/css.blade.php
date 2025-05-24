<link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_option('general')['favicon'] ?? 'assets/images/logo/favicon.png')}}">
{{-- Google Fonts: Saira --}}
<link href="https://fonts.googleapis.com/css?family=Saira:400,700&display=swap" rel="stylesheet">
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min2.css') }}">

<script src="{{ asset('assets/js/layout.js') }}"></script>


<!-- Fontawesome -->
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
{{-- jquery-confirm --}}
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/summernote-lite.css') }}">
<!-- Lily -->
<link rel="stylesheet" href="{{ asset('assets/css/lity.css') }}">
<!-- Style -->

<!-- Toaster -->
<link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">



<link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
@stack('css')

@if (app()->getLocale() == 'ar')
<link rel="stylesheet" href="{{ asset('assets/css/arabic.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
@endif