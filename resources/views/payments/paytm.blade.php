@extends('layouts.web.blank')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0 bg-white rounded-4">
                <div class="card-body text-center">
                    <a class="btn btn-outline-primary d-inline-flex align-items-center mb-3" href="{{ route('business.subscriptions.index') }}">
                        <i class="ri-arrow-left-line me-2"></i> {{ __('Go Back') }}
                    </a>
                    <h4 class="mb-3 fw-bold custom-clr-dark">{{ __('Pay with Paytm') }}</h4>
                    <p class="text-muted mb-4">{{ __('You will be redirected to Paytm to complete your payment securely.') }}</p>
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/Paytm_logo.png" alt="Paytm" style="height: 32px;">
                    </div>
                    <form method="post" action="{{ $paytmUrl }}" name="paytmForm">
                        @foreach($paytmParams as $name => $value)
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endforeach
                        <button class="btn btn-primary w-100 mt-3" type="submit">{{ __('Redirecting to Paytm...') }}</button>
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
