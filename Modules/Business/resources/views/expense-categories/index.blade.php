@extends('business::layouts.master')

@section('title')
    {{ __('Expense Category List') }}
@endsection

@section('content')
    <div class="admin-table-section">
        <div class="container-fluid">
            <div class="card bg-light">
                <div class="card-body">

                    <div class="table-header d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">{{ __('Expense Category List') }}</h4>
                        <a type="button" href="#expense-categories-create-modal" data-bs-toggle="modal"
                            class="btn btn-primary rounded-pill {{ Route::is('admin.expense-categories.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle me-1"></i>{{ __('Add new') }}
                        </a>
                    </div>

                    <div class="table-top-form p-3">
                        <form action="{{ route('business.expense-categories.filter') }}" method="post" class="filter-form"
                            table="#expense-categories-data">
                            @csrf
                            <div class="d-flex gap-3">
                                <div class="form-group">
                                    <select name="per_page" class="form-select">
                                        <option value="10">{{ __('Show- 10') }}</option>
                                        <option value="25">{{ __('Show- 25') }}</option>
                                        <option value="50">{{ __('Show- 50') }}</option>
                                        <option value="100">{{ __('Show- 100') }}</option>
                                    </select>
                                </div>
                                <div class="form-group position-relative">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="{{ __('Search...') }}">
                                    <span class="position-absolute top-50 translate-middle-y end-0 me-3">
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

                <div class="delete-item d-none">
                    <div class="delete-item-show d-flex justify-content-between align-items-center p-3">
                        <p class="fw-bold mb-0"><span class="selected-count"></span> {{ __('items selected') }}</p>
                        <button data-bs-toggle="modal" class="btn btn-danger" data-bs-target="#multi-delete-modal" data-url="{{ route('business.expense-categories.delete-all') }}">{{ __('Delete') }}</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" class="form-check-input select-all-delete multi-delete">
                                </th>
                                <th>{{ __('SL') }}.</th>
                                <th class="text-start">{{ __('Category Name') }}</th>
                                <th class="text-start">{{ __('Description') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="expense-categories-data">
                            @include('business::expense-categories.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $expense_categories->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::expense-categories.create')
    @include('business::expense-categories.edit')
@endpush
