@extends('business::layouts.master')

@section('title')
    {{ request('type') !== 'Supplier' ? __('Create Customer') : __('Create Supplier') }}
@endsection

@section('content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys ">
                <div class="table-header p-16">
                    <h4>{{ __('Add new ') . ucfirst(request('type')) }}</h4>
                        <a href="{{ route('business.parties.index', ['type' => request('type')]) }}"
                           class="add-order-btn rounded-2 {{ Route::is('business.parties.create') ? 'active' : '' }}">
                            <i class="far fa-list" aria-hidden="true"></i>{{ ucfirst(request('type')) . __(' List') }}
                        </a>
                </div>

                <div class="order-form-section p-16">
                    <form action="{{ route('business.parties.store') }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Name') }}</label>
                                    <input type="text" name="name" required class="form-control" placeholder="{{ __('Enter Name') }}">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Phone') }}</label>
                                    <input type="number" name="phone" required class="form-control" placeholder="{{ __('Enter phone number') }}">
                                </div>

                                @if(request('type') !== 'Supplier')
                                <div class="col-lg-6 mb-2">
                                    <label>{{__('Party Type')}}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="type" class="form-control table-select w-100">
                                            <option value=""> {{__('Select one')}}</option>
                                            <option value="Retailer">{{ __('Retailer') }}</option>
                                            <option value="Dealer">{{ __('Dealer') }}</option>
                                            <option value="Wholesaler">{{ __('Wholesaler') }}</option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                                @else
                                <div>
                                    <input type="hidden" name="type" value="Supplier">
                                </div>
                                @endif

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Email') }}</label>
                                    <input type="email" name="email" class="form-control" placeholder="{{ __('Enter Email') }}">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Address') }}</label>
                                    <input type="text" name="address" class="form-control" placeholder="{{ __('Enter Address') }}">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Due') }}</label>
                                    <input type="number" name="due" step="any" class="form-control" placeholder="{{ __('Enter Due') }}">
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-10">
                                            <label class="img-label">{{ __('Image') }}</label>
                                            <input type="file" accept="image/*" name="image" class="form-control file-input-change" data-id="image">
                                        </div>
                                        <div class="col-2 align-self-center mt-3">
                                            <img src="{{ asset('assets/images/icons/upload.png') }}" id="image" class="table-img">
                                        </div>
                                    </div>
                                </div>
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
