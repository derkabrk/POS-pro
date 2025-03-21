@extends('business::layouts.master')

@section('title')
    {{ __('Collect Due') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys ">
                <div class="table-header p-16">
                    <h4>{{ __('Collect Due') }}</h4>
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('business.collect.dues.store') }}" method="POST" class="ajaxform">
                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Select Invoice') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select id="invoiceSelect" name="invoiceNumber" class="form-control table-select w-100">
                                            <option value=""  data-opening-due="{{ $party_opening_due }}" >{{ __('Select an Invoice') }}</option>
                                            @if($party->type == "Supplier")
                                            @foreach ($party->purchases_dues as $due)
                                                <option
                                                    value="{{ $due->invoiceNumber }}"
                                                    data-total-amount="{{ $due->totalAmount }}"
                                                    data-due-amount="{{ $due->dueAmount }}" >
                                                    {{ $due->invoiceNumber }}
                                                </option>
                                            @endforeach
                                            @else
                                                @foreach ($party->sales_dues as $due)
                                                    <option
                                                        value="{{ $due->invoiceNumber }}"
                                                        data-total-amount="{{ $due->totalAmount }}"
                                                        data-due-amount="{{ $due->dueAmount }}" >
                                                        {{ $due->invoiceNumber }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Date') }}</label>
                                    <input type="date" name="paymentDate" required class="form-control" value="{{ date('Y-m-d') }}">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ $party->type == 'Supplier' ? 'Supplier Name' : 'Customer Name' }}</label>
                                    <input type="text" value="{{ $party->name }}" readonly class="form-control">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Total Amount') }}</label>
                                    <input type="number" id="totalAmount" value="{{ $party_opening_due }}" readonly class="form-control">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Paid Amount') }}</label>
                                    <input type="number" name="payDueAmount" id="paidAmount" required class="form-control">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Due Amount') }}</label>
                                    <input type="number" id="dueAmount" value="{{ $party_opening_due }}" readonly class="form-control">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Payment Type') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="payment_type_id" class="form-control table-select w-100 role" required>
                                            @foreach($payment_types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                                 <input type="hidden" name="party_id" value="{{ $party->id }}">

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                        <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
