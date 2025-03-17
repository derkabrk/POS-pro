@extends('layouts.web.blank')

@section('main_content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <a class="theme-btn d-block" href="{{ route('business.subscriptions.index') }}"><i class="fas fa-arrow-left"></i> {{ __('Go Back') }}</a>
                    <form method="post" action="{{ $paytmUrl }}" name="paytmForm">
                        @foreach($paytmParams as $name => $value)
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endforeach
                        <button class="theme-btn d-block mt-3 w-100" type="submit">Redirecting to Paytm...</button>
                    </form>
                    <script>
                        document.paytmForm.submit();
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
