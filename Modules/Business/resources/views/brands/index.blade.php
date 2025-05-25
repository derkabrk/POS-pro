@extends('business::layouts.master')

@section('title')
    {{ __('Brand List') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="brandList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Brand List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <a type="button" href="#brand-create-modal" data-bs-toggle="modal" class="btn btn-primary add-btn"><i class="ri-add-line align-bottom me-1"></i> {{ __('Add new Brand') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.brands.filter') }}" method="post" class="filter-form" table="#business-brand-data" id="brand-search-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}" id="brand-search-input">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select class="form-control" name="per_page" id="per_page">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>{{__('Show- 10')}}</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>{{__('Show- 25')}}</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>{{__('Show- 50')}}</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>{{__('Show- 100')}}</option>
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
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="brandTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th style="width: 25px;">
                                    <div class="form-check">
                                        <input class="form-check-input select-all-delete multi-delete" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Icon') }}</th>
                                <th class="text-start">{{ __('Brand Name') }}</th>
                                <th class="text-start">{{ __('Description') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="business-brand-data">
                            @include('business::brands.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $brands->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    {{-- Moved modal markup from create.blade.php --}}
    <div class="modal fade" id="brand-create-modal" tabindex="-1" aria-labelledby="brandCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="brandCreateModalLabel">{{ __('Add New Brand') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('business.brands.store') }}" method="POST" enctype="multipart/form-data" id="brand-create-form">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="brandName" class="form-label">{{ __('Brand Name') }}</label>
                            <input type="text" class="form-control" id="brandName" name="brandName" required>
                        </div>
                        <div class="mb-3">
                            <label for="brandDescription" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control" id="brandDescription" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="brandIcon" class="form-label">{{ __('Icon') }}</label>
                            <input type="file" class="form-control" id="brandIcon" name="icon" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('business::brands.edit')
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    function fetchBrands() {
        var form = $('#brand-search-form');
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            headers: {'X-CSRF-TOKEN': form.find('input[name="_token"]').val()},
            success: function(response) {
                if(response.data) {
                    $('#business-brand-data').html(response.data);
                } else {
                    $('#business-brand-data').html('<tr><td colspan="7" class="text-center">No data found</td></tr>');
                }
            },
            error: function(xhr) {
                $('#business-brand-data').html('<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }
    $('#brand-search-input').on('input', function() {
        fetchBrands();
    });
    $('#per_page').on('change', function() {
        fetchBrands();
    });
});
</script>
@endpush
