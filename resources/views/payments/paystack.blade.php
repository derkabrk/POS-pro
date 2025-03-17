@extends('layouts.web.blank')

@section('main_content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <a class="theme-btn d-block" href="{{ route('business.subscriptions.index') }}"><i class="fas fa-arrow-left"></i> {{ __('Go Back') }}</a>
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
