<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="{{__('IE=edge')}}">
    <meta name="viewport" content="{{__('width=device-width, initial-scale=1.0')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title') @yield('title') | @endif{{ config('app.name') }}</title>
    @include('layouts.partials.css')
</head>

<body>
@yield('main_content')
@stack('modal')

@include('layouts.auth.partials.scripts')
</body>

</html>
