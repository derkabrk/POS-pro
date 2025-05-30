@extends('business::layouts.master')

@section('title')
    {{ __('Unit List') }}
@endsection

@section('content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card card bg-transparent">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{ __('Unit List') }}</h4>
                        <a type="button" href="#unit-create-modal" data-bs-toggle="modal" class="add-order-btn rounded-2 {{ Route::is('admin.units.create') ? 'active' : '' }}" class="btn btn-primary"><i class="fas fa-plus-circle me-1"></i>{{ __('Add new Unit') }}</a>
                    </div>

                    <div class="table-top-form p-16-0">
                        <form action="{{ route('business.units.filter') }}" method="post" class="filter-form"
                            table="#unit-data">
                            @csrf
                            <div class="table-top-left d-flex gap-3 margin-l-16">
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="per_page" class="form-control">
                                        <option value="10">{{ __('Show- 10') }}</option>
                                        <option value="25">{{ __('Show- 25') }}</option>
                                        <option value="50">{{ __('Show- 50') }}</option>
                                        <option value="100">{{ __('Show- 100') }}</option>
                                    </select>
                                    <span></span>
                                </div>
                                <div class="table-search position-relative">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="{{ __('Search...') }}">
                                    <span class="position-absolute">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                            </svg>

                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="delete-item delete-show d-none">
                    <div class="delete-item-show">
                        <p class="fw-bold"><span class="selected-count"></span> {{ __('items show') }}</p>
                        <button data-bs-toggle="modal" class="trigger-modal" data-bs-target="#multi-delete-modal" data-url="{{ route('business.units.delete-all') }}">{{ __('Delete') }}</button>
                    </div>
                </div>

                <div class="responsive-table">
                    <table class="table table-nowrap mb-0" id="datatable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th scope="col" class="w-60">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input select-all-delete multi-delete">
                                    </div>
                                </th>
                                <th scope="col">{{ __('SL') }}.</th>
                                <th scope="col" class="text-start">{{ __('Unit Name') }}</th>
                                <th scope="col" class="text-center">{{ __('Status') }}</th>
                                <th scope="col" class="print-d-none text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="unit-data">
                            @include('business::units.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $units->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('business::component.delete-modal')

    @include('business::units.create')

    @include('business::units.edit')
@endpush
