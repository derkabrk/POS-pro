<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Pdf Print') }}</title>
    @stack('css')
</head>

<body>
    <div class="table-header">
        <h4>@yield('pdf_title')</h4>
    </div>
    @yield('pdf_content')
</body>

</html>
