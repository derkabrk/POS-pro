@extends('business::layouts.master')

@section('title')
    {{ __('Notifications List') }}
@endsection

@section('content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card card bg-transparent">
                <div class="card-bodys ">
                    <div class="table-header p-16">
                        <h4>{{ __('Notifications List') }}</h4>
                    </div>
                    <div class="table-top-form p-16-0">
                    </div>
                </div>

                <div class="table-responsive table-card m-0">
                    <table class="table table-nowrap mb-0 table-centered align-middle" id="erp-table">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th scope="col">@lang('SL.')</th>
                                <th scope="col">@lang('Message')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Read At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody id="notifications-data" class="searchResults">
                            @include('business::notifications.datas')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
