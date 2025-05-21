@extends('layouts.master')

@section('title')
    {{ __('Blogs List') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('Blogs List') }}</h4>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                    <i class="far fa-plus me-1"></i>{{ __('Create New') }}
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.filter') }}" method="post" class="row g-3 align-items-center mb-3 filter-form" table="#blogs-data">
                    @csrf
                    <div class="col-auto">
                        <select name="per_page" class="form-select">
                            <option value="10">{{ __('Show- 10') }}</option>
                            <option value="25">{{ __('Show- 25') }}</option>
                            <option value="50">{{ __('Show- 50') }}</option>
                            <option value="100">{{ __('Show- 100') }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                    </div>
                </form>
                <div class="table-responsive table-card">
                    <table class="table table-striped table-hover align-middle mb-0" id="datatable">
                        <thead class="table-light">
                            <tr>
                                @can('blogs-delete')
                                    <th>
                                        <div class="d-flex align-items-center gap-1">
                                            <label class="form-check">
                                                <input type="checkbox" class="form-check-input selectAllCheckbox">
                                                <span class="form-check-label"></span>
                                            </label>
                                            <i class="fal fa-trash-alt delete-selected"></i>
                                        </div>
                                    </th>
                                @endcan
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="blogs-data" class="searchResults">
                            @include('admin.website-setting.blogs.datas')
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item">{{ $blogs->links('pagination::bootstrap-5') }}</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
