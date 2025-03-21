@extends('layouts.web.blank')

@section('main_content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="text-center">
                    <img src="{{ asset($gateway->logo) }}" alt="" height="100">
                </div>
                <div class="card-footer bg-white">
                    <button class="btn btn-primary mt-4 col-12 btn-lg w-100" id="rzp-button1">{{ __('Pay Now') }}</button>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ url('/razorpay/status') }}" method="POST" hidden>
        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
        <input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
        <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
        <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
        <button type="submit" id="rzp-paymentresponse" hidden class="btn btn-primary"></button>
    </form>
    <input type="hidden" value="{{ $response['razorpayId'] }}" id="razorpayId">
    <input type="hidden" value="{{ $response['amount'] }}" id="amount">
    <input type="hidden" value="{{ $response['currency'] }}" id="currency">
    <input type="hidden" value="{{ $response['name'] }}" id="name">
    <input type="hidden" value="{{ $response['description'] }}" id="description">
    <input type="hidden" value="{{ $response['orderId'] }}" id="orderId">
    <input type="hidden" value="{{ $response['name'] }}" id="name">
    <input type="hidden" value="{{ $response['email'] }}" id="email">
    <input type="hidden" value="{{ $response['contactNumber'] }}" id="contactNumber">
    <input type="hidden" value="{{ $response['address'] }}" id="address">
@endsection

@push('js')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="{{ asset('assets/js/razorpay.js') }}"></script>
@endpush
