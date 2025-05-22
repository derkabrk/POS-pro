@extends('business::layouts.master')

@section('title')
    {{ __('Income List') }}
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-bottom-0">
            <h4 class="mb-0 fw-semibold text-dark">{{ __('Income List') }}</h4>
            <a href="#incomes-create-modal" data-bs-toggle="modal"
                class="btn btn-primary btn-sm rounded-pill d-flex align-items-center gap-1">
                <i class="fas fa-plus-circle"></i> {{ __('Add new') }}
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('business.incomes.filter') }}" method="post" class="row g-3 align-items-center mb-3 filter-form" table="#incomes-data">
                @csrf
                <div class="col-auto">
                    <select name="per_page" class="form-select form-select-sm">
                        <option value="10">{{ __('Show- 10') }}</option>
                        <option value="25">{{ __('Show- 25') }}</option>
                        <option value="50">{{ __('Show- 50') }}</option>
                        <option value="100">{{ __('Show- 100') }}</option>
                    </select>
                </div>
                <div class="col-auto flex-grow-1">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                        <span class="input-group-text bg-light"><i class="ri-search-line"></i></span>
                    </div>
                </div>
            </form>
            <div class="table-responsive table-card m-0">
                <table class="table table-hover table-nowrap mb-0 align-middle table-striped" id="datatable">
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
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::incomes.create')
    @include('business::incomes.edit')
@endpush
