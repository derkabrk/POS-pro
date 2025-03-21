@extends('layouts.master')

@section('title')
    {{__('Newsletters List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{ __('Newsletters List') }}</h4>
                    </div>
                    <div class="table-top-form">
                        <form action="{{ route('admin.newsletters.index') }}" method="post">
                            @csrf
                            <div class="table-search">
                                <input class="form-control searchInput" type="text" name="search" placeholder="{{ __('Search') }}..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <div class="responsive-table">
                        <table class="table" id="datatable">
                            <thead>
                            <tr>
                                @can('newsletters-delete')
                                    <th class="w-60">
                                        <div class="d-flex align-items-center gap-3" >
                                            <input type="checkbox" class="selectAllCheckbox">
                                            <i class="fal fa-trash-alt delete-selected"></i>
                                        </div>
                                    </th>
                                @endcan
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Create At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="searchResults">
                            @include('admin.website-setting.newsletters.datas')
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">{{ $newsletters->links('pagination::bootstrap-5') }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
