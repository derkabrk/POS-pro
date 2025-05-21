@extends('layouts.master')

@section('title')
    {{ __('Edit Currency') }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('Currencies') }}
        @endslot
        @slot('title')
            {{ __('Edit Currency') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit Currency')}}</h4>
                    <div class="flex-shrink-0">
                        @can('currencies-read')
                        <a href="{{ route('admin.currencies.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('View List') }}
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.currencies.update', $currency->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ $currency->name }}" required class="form-control" placeholder="{{ __('Enter Name') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="code" class="form-label">{{ __('Code') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="code" id="code" value="{{ $currency->code }}" required class="form-control" placeholder="{{ __('Enter Code') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="rate" class="form-label">{{ __('Rate') }} <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="rate" id="rate" value="{{ $currency->rate }}" required class="form-control" placeholder="{{ __('Enter currency rate') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="symbol" class="form-label">{{ __('Symbol') }}</label>
                                        <input type="text" name="symbol" id="symbol" value="{{ $currency->symbol }}" class="form-control" placeholder="{{ __('Enter Symbol') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="position" class="form-label">{{ __('Position') }}</label>
                                        <select name="position" id="position" class="form-control" data-choices data-choices-sorting-false>
                                            <option value="">{{ __('Select a position') }}</option>
                                            <option value="left" @selected('left' == $currency->position)>{{ __('left') }}</option>
                                            <option value="right" @selected('right' == $currency->position)>{{ __('right') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="country_name" class="form-label">{{ __('Country') }}</label>
                                        <select name="country_name" id="country_name" class="form-control" data-choices data-choices-sorting-false>
                                            <option value="">{{ __('Select a Country') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country['name'] }}" @selected($country['name'] == $currency->country_name ?? '')>{{ $country['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <select name="status" id="status" required class="form-control" data-choices data-choices-sorting-false>
                                            <option value="1" @selected($currency->status == 1)>{{ __('Active') }}</option>
                                            <option value="0" @selected($currency->status == 0)>{{ __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-center mt-4">
                                        <button type="reset" class="btn btn-light me-3">{{ __('Reset') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
