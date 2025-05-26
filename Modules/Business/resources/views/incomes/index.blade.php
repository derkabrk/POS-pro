@extends('business::layouts.master')

@section('title')
    {{ __('Income List') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card" id="incomeList">
            <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ __('Income List') }}</h5>
                <a href="#incomes-create-modal" data-bs-toggle="modal"
                    class="btn btn-primary add-btn btn-sm rounded-pill d-flex align-items-center gap-1">
                    <i class="fas fa-plus-circle"></i> {{ __('Add new') }}
                </a>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.incomes.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3 mb-3" table="#incomes-data">
                    @csrf
                    <div class="row g-3 w-100">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input class="form-control search" type="text" name="search" placeholder="{{ __('Search...') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select class="form-control" name="per_page">
                                    <option value="10">{{ __('Show- 10') }}</option>
                                    <option value="25">{{ __('Show- 25') }}</option>
                                    <option value="50">{{ __('Show- 50') }}</option>
                                    <option value="100">{{ __('Show- 100') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <!-- Removed filter/search button for real-time search -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-top-btn-group d-flex gap-2 mb-3">
                    <a href="{{ route('business.incomes.csv') }}" class="btn btn-secondary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                        <i class="ri-file-list-2-line me-1"></i> <span>{{ __('Export CSV') }}</span>
                    </a>
                    <a href="{{ route('business.incomes.excel') }}" class="btn btn-success btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                        <i class="ri-file-excel-2-line me-1"></i> <span>{{ __('Export Excel') }}</span>
                    </a>
                    <a onclick="window.print()" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm print-window">
                        <i class="ri-printer-line me-1"></i> <span>{{ __('Print') }}</span>
                    </a>
                </div>
                <div class="table-responsive table-card m-0">
                    <table class="table table-nowrap mb-0 align-middle table-striped" id="incomesTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th class="w-60 checkbox"></th>
                                <th scope="col">#</th>
                                <th scope="col" class="text-start">{{ __('Amount') }}</th>
                                <th scope="col" class="text-start">{{ __('Category') }}</th>
                                <th scope="col" class="text-start">{{ __('For') }}</th>
                                <th scope="col" class="text-start">{{ __('Payment Type') }}</th>
                                <th scope="col" class="text-start">{{ __('Reference') }}</th>
                                <th scope="col" class="text-start">{{ __('Date') }}</th>
                                <th scope="col" class="print-d-none">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="incomes-data">
                            @include('business::incomes.datas')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::incomes.create')
    @include('business::incomes.edit')
@endpush
