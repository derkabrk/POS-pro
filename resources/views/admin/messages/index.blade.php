@extends('layouts.master')

@section('title')
    {{ __('Messages') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ __('Messages List') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.messages.filter') }}" method="post" class="row g-3 align-items-center mb-3 filter-form" table="#messages-data">
                    @csrf
                    <div class="col-auto">
                        <select name="per_page" class="form-control">
                            <option value="10">{{ __('Show- 10') }}</option>
                            <option value="25">{{ __('Show- 25') }}</option>
                            <option value="50">{{ __('Show- 50') }}</option>
                            <option value="100">{{ __('Show- 100') }}</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="erp-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="d-flex align-items-center gap-1">
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input selectAllCheckbox">
                                            <span class="form-check-label"></span>
                                        </label>
                                        <i class="fal fa-trash-alt delete-selected"></i>
                                    </div>
                                </th>
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Company Name') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="messages-data" class="searchResults">
                            @include('admin.messages.datas')
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item">{{ $messages->links('pagination::bootstrap-5') }}</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
