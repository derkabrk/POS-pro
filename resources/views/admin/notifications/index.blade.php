@extends('layouts.master')

@section('title')
    {{ __('Notifications List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys ">
                    <div class="table-header p-16">
                        <h4>{{ __('Notifications List') }}</h4>
                    </div>
                    <div class="table-top-form p-16-0">
                    </div>
                </div>

                <div class="responsibe-table m-0">
                    <table class="table" id="erp-table">
                        <thead>
                            <tr>
                                <th>@lang('SL.')</th>
                                <th>@lang('Message')</th>
                                <th>@lang('Created At')</th>
                                <th>@lang('Read At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody id="notifications-data" class="searchResults">
                            @include('admin.notifications.datas')
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
