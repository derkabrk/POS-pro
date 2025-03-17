@extends('layouts.master')

@section('title')
    {{ __('Add Currency') }}
@endsection

@section('main_content')
    <div class="order-form-section">
        <div class="erp-table-section">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-bodys">
                        <div class="table-header p-16">
                            <h4>{{ __('Add Currency') }}</h4>

                            @can('currencies-read')
                                <a href="{{ route('admin.currencies.index') }}"
                                    class="add-order-btn rounded-2 {{ Route::is('admin.currencies.create') ? 'active' : '' }}"><i
                                        class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}</a>
                            @endcan
                        </div>
                        <form action="{{ route('admin.currencies.store') }}" method="post" enctype="multipart/form-data"
                            class="ajaxform_instant_reload">
                            @csrf
                            <div class="row p-16">
                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Name') }}</label>
                                    <input type="text" name="name" required class="form-control"
                                        placeholder="{{ __('Enter Name') }}">
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Code') }}</label>
                                    <input type="text" name="code" required class="form-control"
                                        placeholder="{{ __('Enter Code') }}">
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Rate') }}</label>
                                    <input type="number" name="rate" required class="form-control"
                                           placeholder="{{ __('Enter currency rate') }}">
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Symbol') }}</label>
                                    <input type="text" name="symbol" class="form-control" placeholder="{{ __('Enter Symbol') }}">
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Position') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                    <select name="position" class="form-control table-select w-100">
                                        <option value="">{{ __('Select a position') }}</option>
                                        <option value="left">{{ __('left') }}</option>
                                        <option value="right">{{ __('right') }}</option>
                                    </select>
                                    <span></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Country') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                    <select name="country_name" class="form-control table-select w-100">
                                        <option value="">{{ __('Select a Country') }}</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <span></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Status') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                    <select name="status" required class="form-control table-select w-100">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                    <span></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="reset"
                                            class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                        <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
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
