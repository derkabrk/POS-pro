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
                        <h4 class="mb-3 fw-bold custom-clr-dark">{{ __('Pay with Paystack') }}</h4>
                        <p class="text-muted mb-4">{{ __('You will be redirected to Paystack to complete your payment securely.') }}</p>
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <img src="https://assets.paystack.com/assets/img/logos/paystack-logo-primary.svg" alt="Paystack" style="height: 32px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" class="status" action="{{ route('paystack.status') }}">
        @csrf
        <input type="hidden" name="ref_id" id="ref_id">
        <input type="hidden" value="{{ $Info['currency'] }}" id="currency">
        <input type="hidden" value="{{ $Info['amount'] }}" id="amount">
        <input type="hidden" value="{{ $Info['public_key'] }}" id="public_key">
        <input type="hidden" value="{{ $Info['email'] ?? Auth::user()->email }}" id="email">
    </form>
@endsection


@push('js')
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        "use strict";

        $('#payment_btn').on('click', () => {
            payWithPaystack();
        });
        payWithPaystack();

        function payWithPaystack() {
            var amont = $('#amount').val() * 100;
            let handler = PaystackPop.setup({
                key: $('#public_key').val(), // Replace with your public key
                email: $('#email').val(),
                amount: amont,
                currency: $('#currency').val(),
                ref: 'ps_{{ Str::random(15) }}',
                onClose: function() {
                    payWithPaystack();
                },
                callback: function(response) {
                    $('#ref_id').val(response.reference);
                    $('.status').submit();
                }
            });
            handler.openIframe();
        }
    </script>
@endpush
