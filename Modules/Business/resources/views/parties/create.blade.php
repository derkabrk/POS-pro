@extends('business::layouts.master')

@section('title')
    {{ request('type') !== 'Supplier' ? __('Create Customer') : __('Create Supplier') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ request('type') !== 'Supplier' ? __('Create Customer') : __('Create Supplier') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <a href="{{ route('business.parties.index', ['type' => request('type')]) }}" class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-list-unordered me-1"></i>{{ ucfirst(request('type')) . __(' List') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('business.parties.store') }}" method="POST" class="ajaxform_instant_reload" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input type="text" name="name" required class="form-control" placeholder="{{ __('Enter Name') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{ __('Phone') }}</label>
                            <input type="number" name="phone" required class="form-control" placeholder="{{ __('Enter phone number') }}">
                        </div>
                        @if(request('type') !== 'Supplier')
                        <div class="col-lg-6">
                            <label class="form-label">{{__('Party Type')}}</label>
                            <select name="type" class="form-select">
                                <option value=""> {{__('Select one')}}</option>
                                <option value="Retailer">{{ __('Retailer') }}</option>
                                <option value="Dealer">{{ __('Dealer') }}</option>
                                <option value="Wholesaler">{{ __('Wholesaler') }}</option>
                            </select>
                        </div>
                        @else
                        <input type="hidden" name="type" value="Supplier">
                        @endif
                        <div class="col-lg-6">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control" placeholder="{{ __('Enter Email') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{ __('Address') }}</label>
                            <input type="text" name="address" class="form-control" placeholder="{{ __('Enter Address') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{ __('Due') }}</label>
                            <input type="number" name="due" step="any" class="form-control" placeholder="{{ __('Enter Due') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{ __('Image') }}</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="file" accept="image/*" name="image" class="form-control file-input-change" data-id="image">
                                <img src="{{ asset('assets/images/icons/upload.png') }}" id="image" style="width:48px;height:48px;object-fit:cover;border-radius:6px;" alt="Img Preview">
                            </div>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-2">{{ __('Reset') }}</button>
                            <button class="btn btn-primary px-4">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
