@extends('layouts.master')
@section('title') {{ __('Business List') }} @endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Business @endslot
@slot('title') {{ __('Business List') }} @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Business List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            @can('business-read')
                                <a type="button" href="{{route('admin.business.create')}}" class="btn btn-primary add-btn {{ Route::is('admin.business.create') ? 'active' : '' }}"><i class="ri-add-line align-bottom me-1"></i> {{ __('Add new Business') }}</a>
                            @endcan
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('admin.business.filter') }}" method="POST" id="filter-form" class="filter-form" table="#business-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" placeholder="Select date">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" name="per_page" id="per_page">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" name="type" id="sale_type_filter">
                                    <option value="all">{{ __('All') }}</option>
                                    <option value="1">{{ __('E-commerce') }}</option>
                                    <option value="2">{{ __('Both') }}</option>
                                    <option value="0">{{ __('Physical') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    {{ __('Filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div>
                    <ul class="nav nav-tabs nav-tabs-custom nav-primary mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active All py-3" data-bs-toggle="tab" id="All" href="#home1" role="tab" aria-selected="true">
                                <i class="ri-store-2-fill me-1 align-bottom"></i> {{ __('All Businesses') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 Ecommerce" data-bs-toggle="tab" id="Ecommerce" href="#ecommerce" role="tab" aria-selected="false">
                                <i class="ri-shopping-cart-line me-1 align-bottom"></i> {{ __('E-commerce') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 Physical" data-bs-toggle="tab" id="Physical" href="#physical" role="tab" aria-selected="false">
                                <i class="ri-building-line me-1 align-bottom"></i> {{ __('Physical') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 Both" data-bs-toggle="tab" id="Both" href="#both" role="tab" aria-selected="false">
                                <i class="ri-store-line me-1 align-bottom"></i> {{ __('Both') }}
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive table-card">
                        <table class="table table-nowrap mb-0" id="orderTable">
                            <thead class="table-light">
                                <tr class="text-uppercase">
                                    <th scope="col" style="width: 25px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="id">{{ __('SL') }}.</th>
                                    <th class="sort" data-sort="business_name">{{ __('Business Name') }}</th>
                                    <th class="sort" data-sort="business_category">{{ __('Business Category') }}</th>
                                    <th class="sort" data-sort="business_type">{{ __('Business Type') }}</th>
                                    <th class="sort" data-sort="phone">{{ __('Phone') }}</th>
                                    <th class="sort" data-sort="package">{{ __('Package') }}</th>
                                    <th class="sort" data-sort="last_enroll">{{ __('Last Enroll') }}</th>
                                    <th class="sort" data-sort="expired_date">{{ __('Expired Date') }}</th>
                                    <th class="sort" data-sort="action">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all" id="business-data">
                                @foreach($businesses as $key => $business)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="checkAll" value="{{ $business->id }}">
                                        </div>
                                    </th>
                                    <td class="id">{{ $loop->iteration }}</td>
                                    <td class="business_name">{{ $business->business_name ?? 'N/A' }}</td>
                                    <td class="business_category">{{ $business->category->name ?? 'N/A' }}</td>
                                    <td class="business_type">
                                        @if($business->type == 0)
                                            <span class="badge bg-info-subtle text-info">{{ __('Physical') }}</span>
                                        @elseif($business->type == 1)
                                            <span class="badge bg-primary-subtle text-primary">{{ __('E-commerce') }}</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success">{{ __('Both') }}</span>
                                        @endif
                                    </td>
                                    <td class="phone">{{ $business->user->phone ?? 'N/A' }}</td>
                                    <td class="package">
                                        {{ optional(optional($business->getCurrentPackage)->plan)->subscriptionName ?? 'N/A' }}
                                    </td>
                                    <td class="last_enroll">
                                        {{ optional($business->getCurrentPackage)->created_at ? optional($business->getCurrentPackage)->created_at->format('d M, Y') : 'N/A' }}
                                    </td>
                                    <td class="expired_date">
                                        {{ optional($business->getCurrentPackage)->expieryDate ? optional($business->getCurrentPackage)->expieryDate->format('d M, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#business-view-modal" 
                                                   data-business-id="{{ $business->id }}"
                                                   data-business-name="{{ $business->business_name }}"
                                                   data-category="{{ $business->category->name ?? 'N/A' }}"
                                                   data-phone="{{ $business->user->phone ?? 'N/A' }}"
                                                   data-address="{{ $business->address ?? 'N/A' }}"
                                                   data-package="{{ $business->getCurrentPackage && $business->getCurrentPackage->plan ? $business->getCurrentPackage->plan->subscriptionName : 'N/A' }}"
                                                   data-last-enroll="{{ $business->getCurrentPackage && $business->getCurrentPackage->created_at ? $business->getCurrentPackage->created_at->format('d M, Y') : 'N/A' }}"
                                                   data-expired-date="{{ $business->getCurrentPackage && $business->getCurrentPackage->expieryDate ? $business->getCurrentPackage->expieryDate->format('d M, Y') : 'N/A' }}"
                                                   data-created-date="{{ $business->created_at ? $business->created_at->format('d M, Y') : 'N/A' }}"
                                                   data-image="{{ asset($business->image) }}"
                                                   class="text-primary d-inline-block view-btn">
                                                    <i class="ri-eye-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @can('business-update')
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a href="{{ route('admin.business.edit', $business->id) }}" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @endcan
                                            @can('business-delete')
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn delete-btn" data-bs-toggle="modal" 
                                                   data-id="{{ $business->id }}" href="#deleteOrder">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @endcan
                                            @can('business-update')
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Upgrade Plan">
                                                <a class="text-success d-inline-block upgrade-plan-btn" data-bs-toggle="modal" 
                                                   data-id="{{ $business->id }}"
                                                   data-business-name="{{ $business->business_name }}"
                                                   href="#business-upgrade-modal">
                                                    <i class="ri-arrow-up-circle-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">{{ __('Sorry! No Result Found') }}</h5>
                                <p class="text-muted">{{ __("We've searched more than 150+ Businesses We did not find any businesses for you search.") }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $businesses->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Business') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            <form class="tablelist-form" autocomplete="off" action="{{ route('admin.business.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="business-name-field" class="form-label">{{ __('Business Name') }}</label>
                                        <input type="text" id="business-name-field" class="form-control" name="business_name" placeholder="{{ __('Enter business name') }}" required />
                                    </div>

                                    <div class="mb-3">
                                        <label for="category-field" class="form-label">{{ __('Category') }}</label>
                                        <select class="form-control" data-trigger name="category_id" id="category-field" required>
                                            <option value="">{{ __('Select Category') }}</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address-field" class="form-label">{{ __('Address') }}</label>
                                        <textarea id="address-field" class="form-control" name="address" placeholder="{{ __('Enter address') }}"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="business-type-field" class="form-label">{{ __('Business Type') }}</label>
                                        <select class="form-control" data-trigger name="type" id="business-type-field" required>
                                            <option value="">{{ __('Select Type') }}</option>
                                            <option value="0">{{ __('Physical') }}</option>
                                            <option value="1">{{ __('E-commerce') }}</option>
                                            <option value="2">{{ __('Both') }}</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone-field" class="form-label">{{ __('Phone') }}</label>
                                        <input type="text" id="phone-field" class="form-control" name="phone" placeholder="{{ __('Enter phone number') }}" required />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                        <button type="submit" class="btn btn-success" id="add-btn">{{ __('Add Business') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>{{ __('You are about to delete a business?') }}</h4>
                                    <p class="text-muted fs-15 mb-4">{{ __('Deleting your business will remove all of your information from our database.') }}</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                            {{ __('Close') }}</button>
                                        <form action="" method="POST" id="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" id="delete-record">{{ __('Yes, Delete It') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal -->

                <!-- Business Plan Update modal -->
                <div class="modal modal-md fade" id="business-upgrade-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Upgrade Plan') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload upgradePlan">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <label>{{ __('Business Name') }}</label>
                                        <input class="form-control" id="business_name" readonly>
                                        <input name="business_id" id="business_id" type="hidden">
                                    </div>

                                    <div class="mb-3">
                                        <label for="plan_id">{{ __('Select A Plan') }}</label>
                                        <select name="plan_id" id="plan_id" class="form-control">
                                            <option value="">{{ __('Select One') }}</option>
                                            @foreach ($plans as $plan)
                                                <option data-price="{{ $plan->offerPrice ?? $plan->subscriptionPrice }}" value="{{ $plan->id }}">{{ $plan->subscriptionName }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>{{ __('Price') }}</label>
                                        <input class="form-control plan-price" name="price" type="number" step="any" placeholder="{{ __('Enter plan price or select a plan') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label>{{ __('Expiry Date') }}</label>
                                        <input type="datetime-local" id="datepicker" name="expieryDate" class="form-control" data-provider="flatpickr">
                                    </div>

                                    <div class="mb-3">
                                        <label>{{ __('Notes') }}</label>
                                        <textarea name="notes" id="notes" class="form-control" placeholder="{{ __('Enter notes') }}">{{ 'Plan subscribed by '. auth()->user()->name }}</textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="reset" class="btn btn-light">{{ __('Reset') }}</button>
                                            <button type="submit" class="btn btn-success submit-btn">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business View Modal -->
                <div class="modal fade" id="business-view-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title">{{ __('Business View') }} (<span class="business_name"></span>)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="personal-info">
                                    <div class="row mt-2">
                                        <div class="col-12 text-center">
                                            <img width="100px" class="rounded-circle border-2 shadow" src="" id="image" alt="">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-4">
                                        <div class="col-md-4"><p>{{ __('Business Name') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p class="business_name"></p></div>
                                    </div>

                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-4"><p>{{ __('Business Category') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p id="category"></p></div>
                                    </div>

                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-4"><p>{{ __('Phone') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p id="phone"></p></div>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-4"><p>{{ __('Address') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p id="address"></p></div>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-4"><p>{{ __('Package') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p id="package"></p></div>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-4"><p>{{ __('Upgrade Date') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p id="last_enroll"></p></div>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-4"><p>{{ __('Expired Date') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p id="expired_date"></p></div>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-4"><p>{{ __('Created date') }}</p></div>
                                        <div class="col-1"><p>:</p></div>
                                        <div class="col-md-7"><p id="created_date"></p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<script>
    // View business details
    $(document).on('click', '.view-btn', function() {
        var businessName = $(this).data('business-name');
        var category = $(this).data('category');
        var phone = $(this).data('phone');
        var address = $(this).data('address');
        var package = $(this).data('package');
        var lastEnroll = $(this).data('last-enroll');
        var expiredDate = $(this).data('expired-date');
        var createdDate = $(this).data('created-date');
        var image = $(this).data('image');
        
        $('.business_name').text(businessName);
        $('#category').text(category);
        $('#phone').text(phone);
        $('#address').text(address);
        $('#package').text(package);
        $('#last_enroll').text(lastEnroll);
        $('#expired_date').text(expiredDate);
        $('#created_date').text(createdDate);
        $('#image').attr('src', image);
    });
    
    // Delete business
    $(document).on('click', '.delete-btn', function() {
        var businessId = $(this).data('id');
        var url = "{{ route('admin.business.destroy', ':id') }}";
        url = url.replace(':id', businessId);
        $('#delete-form').attr('action', url);
    });
    
    // Upgrade plan
    $(document).on('click', '.upgrade-plan-btn', function() {
        var businessId = $(this).data('id');
        var businessName = $(this).data('business-name');
        
        $('#business_id').val(businessId);
        $('#business_name').val(businessName);
    });
    
    // Plan price update
    $(document).on('change', '#plan_id', function() {
        var price = $(this).find(':selected').data('price');
        $('.plan-price').val(price);
    });
    
    // Search functionality
    function SearchData() {
        $('#filter-form').submit();
    }
</script>
@endsection