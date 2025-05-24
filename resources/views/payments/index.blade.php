@extends('layouts.web.blank')

@section('content')
<section class="payment-method-section py-5 bg-light bg-opacity-50">
    <div class="container">
        <div class="payment-method-wrp">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="nav flex-column nav-pills payment-method-nav rounded-3 shadow-sm p-3 bg-white">
                        @foreach ($gateways as $gateway)
                        <a href="#{{ str_replace(' ', '-', $gateway->name) }}" data-bs-toggle="pill" @class(['nav-link payment-items mb-2 fw-semibold custom-clr-dark', 'active' => $loop->first ? true : false])>
                            <i class="ri-bank-card-line me-2"></i>{{ ucfirst($gateway->name) }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-8 mt-3 mt-sm-0">
                    <div class="tab-content">
                        @foreach ($gateways as $gateway)
                        <div @class(['tab-pane fade', 'show active' => $loop->first ? true : false]) id="{{ str_replace(' ', '-', $gateway->name) }}">
                            <form action="{{ route('payments-gateways.payment', ['plan_id' => $plan->id, 'gateway_id' => $gateway->id]) }}" method="post" enctype="multipart/form-data" class="bg-white rounded-4 shadow-sm p-4">
                                @csrf
                                <div class="payment-list-table">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                            <i class="ri-error-warning-line me-2"></i>{{ $error }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @endforeach
                                    @endif
                                    <h5 class="payment-title mb-3 fw-bold custom-clr-dark"><i class="ri-bank-card-2-line me-2"></i>{{ ucfirst($gateway->name) }} ({{ optional($gateway->currency)->code }})</h5>
                                    <table class="table table-card align-middle mb-4 border rounded-3 overflow-hidden">
                                        <tbody>
                                            @php
                                                $amount = convert_money($plan->offerPrice ?? $plan->subscriptionPrice, $gateway->currency);
                                            @endphp
                                            <tr>
                                                <th class="bg-light custom-clr-light">{{ __('Gateway Name') }}</th>
                                                <td>{{ $gateway->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light custom-clr-light">{{ __('Gateway Currency') }}</th>
                                                <td>{{ optional($gateway->currency)->code }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light custom-clr-light">{{ __('Gateway Rate') }}</th>
                                                <td>{{ currency_format($gateway->currency->rate, currency:$gateway->currency) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light custom-clr-light">{{ __('Subscription Name') }}</th>
                                                <td>{{ $plan->subscriptionName }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light custom-clr-light">{{ __('Subscription Price') }}</th>
                                                <td>{{ currency_format($amount, currency : $gateway->currency) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light custom-clr-light">{{ __('Gateway Charge') }}</th>
                                                <td>{{ currency_format($gateway->charge, currency: $gateway->currency) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light custom-clr-light">{{ __('Payable Amount') }}</th>
                                                <td class="fw-bold custom-clr-primary">{{ currency_format($amount + $gateway->charge, currency: $gateway->currency) }}</td>
                                            </tr>
                                            @if ($gateway->phone_required == 1)
                                            <tr>
                                                <th class="bg-light custom-clr-light">
                                                    <label for="phone" class="required">{{ __('Phone Number') }}</label>
                                                </th>
                                                <td>
                                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Enter your phone number') }}" required>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    @if ($gateway->instructions)
                                    <div class="mb-3">
                                        <h5 class="payment-title mb-3 fw-bold custom-clr-dark"><i class="ri-information-line me-2"></i>{{ __('Instructions') }}</h5>
                                        <div class="alert alert-info bg-opacity-25 border-0 text-secondary">{!! $gateway->instructions !!}</div>
                                    </div>
                                    @endif
                                    @if ($gateway->is_manual)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            @if ($gateway->accept_img)
                                            <div class="form-group mb-3">
                                                <label for="attachment" class="form-label">{{ __('Screenshot/Proof Image') }}</label>
                                                <input type="file" name="attachment" id="attachment" class="form-control" required>
                                            </div>
                                            @endif
                                            @foreach ($gateway->manual_data['label'] ?? [] as $key => $row)
                                            <div class="form-group mb-3">
                                                <label for="manual_data_{{ $key }}" class="form-label">{{ $row }}</label>
                                                <input type="text" name="manual_data[]" id="manual_data_{{ $key }}" @required($gateway->manual_data['is_required'][$key] == 1) class="form-control" placeholder="{{ __('Enter ').$row }}">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary payment-btn px-4 py-2 fw-semibold shadow-sm"><i class="ri-arrow-right-circle-line me-2"></i>{{ __('Pay Now') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/payments.css') }}">
@endpush
