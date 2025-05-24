@extends('layouts.web.blank')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-sm border-0 bg-white rounded-4">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img src="{{ asset($gateway->logo) }}" alt="Razorpay" style="height: 60px;">
                        </div>
                        <h4 class="mb-3 fw-bold custom-clr-dark">{{ __('Pay with Razorpay') }}</h4>
                        <p class="text-muted mb-4">{{ __('You will be redirected to Razorpay to complete your payment securely.') }}</p>
                        <button class="btn btn-primary btn-lg w-100 mt-2" id="rzp-button1">
                            <i class="ri-bank-card-line me-2"></i>{{ __('Pay Now') }}
                        </button>
                    </div>
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
