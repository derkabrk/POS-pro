@extends('business::layouts.master')

@section('title')
    {{ __('Product Variants') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card" id="variantList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Product Variants') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('business.product-variants.create') }}" class="btn btn-primary add-btn"><i class="ri-add-line align-bottom me-1"></i> {{ __('Add new Variant') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.product-variants.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3" table="#variant-data" id="variant-search-form">
                    @csrf
                    <div class="row g-3 w-100">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input class="form-control search" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}" id="variant-search-input">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select class="form-control" name="per_page" id="variant_per_page">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>{{__('Show- 10')}}</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>{{__('Show- 25')}}</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>{{__('Show- 50')}}</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>{{__('Show- 100')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="variantTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Variant Name') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="variant-data">
                            @include('business::products.partials.variant-datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{-- $variants->links('vendor.pagination.bootstrap-5') --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Delete Variant
    $(document).on('click', '.delete-variant', function() {
        var btn = $(this);
        var id = btn.data('id');
        if(confirm('Are you sure you want to delete this variant?')) {
            btn.prop('disabled', true);
            var originalHtml = btn.html();
            btn.html('<span class="spinner-border spinner-border-sm"></span>');
            $.ajax({
                url: '/business/product-variants/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    btn.html(originalHtml);
                    btn.prop('disabled', false);
                    if(response.message) {
                        // Try to remove the row, fallback to reload if not found
                        var row = btn.closest('tr');
                        if(row.length) {
                            row.remove();
                        } else {
                            location.reload();
                        }
                        if(window.Swal) {
                            Swal.fire('Success', response.message, 'success');
                        } else {
                            alert(response.message);
                        }
                    } else {
                        alert('Deleted, but no message returned.');
                    }
                },
                error: function(xhr) {
                    btn.html(originalHtml);
                    btn.prop('disabled', false);
                    let msg = 'Delete failed!';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    if(window.Swal) {
                        Swal.fire('Error', msg, 'error');
                    } else {
                        alert(msg);
                    }
                }
            });
        }
    });
});
</script>
@endpush
