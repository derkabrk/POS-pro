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
                                <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" name="date_range" placeholder="Select date">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" data-choices data-choices-search-false name="per_page" id="per_page">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" data-choices data-choices-search-false name="type" id="sale_type_filter">
                                    <option value="all">{{ __('All') }}</option>
                                    <option value="1">{{ __('E-commerce') }}</option>
                                    <option value="2">{{ __('Both') }}</option>
                                    <option value="0">{{ __('Physical') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <button type="button" class="btn btn-primary w-100" id="filter-button"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
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

                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="orderTable">
                            <thead class="text-muted table-light">
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
                                    <td class="business_name">{{ $business->business_name }}</td>
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
                                        {{ $business->enrolled_plan && $business->enrolled_plan->plan ? $business->enrolled_plan->plan->subscriptionName : '' }}
                                    </td>
                                    <td class="last_enroll">
                                        {{ $business->subscriptionDate ? formatted_date($business->subscriptionDate) : '' }}
                                    </td>
                                    <td class="expired_date">
                                        {{ $business->will_expire ? formatted_date($business->will_expire) : '' }}
                                    </td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="#business-view-modal" class="text-primary d-inline-block view-btn business-view" data-bs-toggle="modal"
                                                   data-image="{{ asset($business->pictureUrl ?? 'assets/img/default-shop.svg') }}"
                                                   data-name="{{ $business->companyName }}" data-address="{{ $business->address }}"
                                                   data-category="{{ $business->category->name ?? '' }}"
                                                   data-type="{{  $business->type}}"
                                                   data-phone="{{ $business->phoneNumber }}"
                                                   data-package="{{ $business->enrolled_plan && $business->enrolled_plan->plan ? $business->enrolled_plan->plan->subscriptionName : '' }}"
                                                   data-last_enroll="{{ $business->subscriptionDate ? formatted_date($business->subscriptionDate) : '' }}"
                                                   data-expired_date="{{ $business->will_expire ? formatted_date($business->will_expire) : '' }}"
                                                   data-created_date="{{ $business->created_at ? formatted_date($business->created_at) : '' }}">
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
                                        <select name="plan_id" id="plan_id" class="form-control" data-choices data-choices-search-false>
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
<!-- Required Javascript libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<script>
    // Initialize form elements when document is ready
    $(document).ready(function() {
        // Initialize flatpickr date pickers
        if (typeof flatpickr !== 'undefined') {
            flatpickr("[data-provider='flatpickr']", {
                dateFormat: "d M, Y",
                allowInput: true
            });
        }
        
        // Initialize Choices.js selects safely
        if (typeof Choices !== 'undefined') {
            document.querySelectorAll("[data-choices]").forEach(function(element) {
                if (!element.classList.contains('choices__input') && 
                    !element.classList.contains('choices__inner') && 
                    !element.parentElement.classList.contains('choices')) {
                    new Choices(element, {
                        searchEnabled: !(element.getAttribute("data-choices-search-false") === "true"),
                        itemSelectText: '',
                    });
                }
            });
        }
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Define the search function
        window.performSearch = function() {
            // Show loading indicator
            $('#business-data').html('<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>');
            
            // Get form data
            var form = $('#filter-form')[0];
            var formData = new FormData(form);
            
            // Make AJAX request
            $.ajax({
                url: "{{ route('admin.business.filter') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Update table with response
                    $('#business-data').html(response);
                    
                    // Reinitialize tooltips for new content
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                    
                    // Show/hide no result message
                    if ($.trim(response) === '' || $(response).find('tr').length === 0) {
                        $('.noresult').show();
                    } else {
                        $('.noresult').hide();
                    }
                },
                error: function(xhr) {
                    // Show error message
                    $('#business-data').html('<tr><td colspan="10" class="text-center text-danger">Error loading data. Please try again.</td></tr>');
                    console.error('Search error:', xhr);
                    
                    // Display error notification
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('Error') }}",
                        text: "{{ __('An error occurred while filtering data') }}",
                        confirmButtonClass: 'btn btn-primary'
                    });
                }
            });
        };
        
        // Button click event
        $('#filter-button').on('click', function() {
            performSearch();
        });
        
        // Form submit event (prevent default and use AJAX)
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            performSearch();
        });
        
        // Tab handling for business types
        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var type = $(this).attr('id');
            
            // Update active tab visually
            $('.nav-tabs .nav-link').removeClass('active');
            $(this).addClass('active');
            
            // Set the correct value in the filter dropdown
            if (type === 'All') {
                type = 'all';
            } else if (type === 'Ecommerce') {
                type = '1';
            } else if (type === 'Physical') {
                type = '0';
            } else if (type === 'Both') {
                type = '2';
            }
            
            // Set the filter dropdown value
            $('#sale_type_filter').val(type).trigger('change.select2');
            
            // Apply filter immediately
            performSearch();
        });
        
        // Setup event listeners for real-time filtering
        
        // Search input keyup event with debounce
        var searchTimeout;
        $('input[name="search"]').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch();
            }, 500); // 500ms delay to avoid too many requests
        });
        
        // Date range picker change event
        $('#demo-datepicker').on('change', function() {
            performSearch();
        });
        
        // Per page selector change event
        $('#per_page').on('change', function() {
            performSearch();
        });
        
        // Business type filter change event
        $('#sale_type_filter').on('change', function() {
            performSearch();
        });
        
        // Check/uncheck all checkboxes
        $('#checkAll').on('change', function() {
            $('input[name="checkAll"]').prop('checked', $(this).prop('checked'));
        });
        
        // Function to handle multiple deletions
       
        // Handle View Business details
        $(document).on('click', '.business-view', function() {
            var name = $(this).data('name');
            var category = $(this).data('category');
            var phone = $(this).data('phone');
            var address = $(this).data('address');
            var package = $(this).data('package');
            var lastEnroll = $(this).data('last_enroll');
            var expiredDate = $(this).data('expired_date');
            var createdDate = $(this).data('created_date');
            var image = $(this).data('image');
            
            $('.business_name').text(name);
            $('#category').text(category);
            $('#phone').text(phone);
            $('#address').text(address);
            $('#package').text(package);
            $('#last_enroll').text(lastEnroll);
            $('#expired_date').text(expiredDate);
            $('#created_date').text(createdDate);
            $('#image').attr('src', image);
        });
        
        // Handle Delete Business action
        $(document).on('click', '.delete-btn', function() {
            var businessId = $(this).data('id');
            var url = "{{ route('admin.business.destroy', ':id') }}";
            url = url.replace(':id', businessId);
            $('#delete-form').attr('action', url);
        });
        
        // Handle Upgrade Plan action
        $(document).on('click', '.upgrade-plan-btn', function() {
            var businessId = $(this).data('id');
            var businessName = $(this).data('business-name');
            
            // Set modal form values
            $('#business_id').val(businessId);
            $('#business_name').val(businessName);
            
            // Set the form action URL
            var url = "{{ route('admin.business.upgrade.plan', ':id') }}";
            url = url.replace(':id', businessId);
            $('.upgradePlan').attr('action', url);
        });
        
        // Plan price update on selection
        $(document).on('change', '#plan_id', function() {
            var price = $(this).find(':selected').data('price');
            $('.plan-price').val(price);
        });
        
        // Handle upgrade plan form submission with AJAX
        $('.upgradePlan').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var formData = new FormData(form[0]);
            
            // Show loading indicator
            var submitBtn = form.find('.submit-btn');
            var originalText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            submitBtn.prop('disabled', true);
            
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                    
                    if (response.success) {
                        Swal.fire({
                            title: "{{ __('Success!') }}",
                            text: response.message || "{{ __('Plan upgraded successfully.') }}",
                            icon: "success",
                            confirmButtonClass: "btn btn-primary w-xs mt-2",
                            buttonsStyling: false
                        }).then(function() {
                            $('#business-upgrade-modal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "{{ __('Error!') }}",
                            text: response.message || "{{ __('Something went wrong.') }}",
                            icon: "error",
                            confirmButtonClass: "btn btn-primary w-xs mt-2",
                            buttonsStyling: false
                        });
                    }
                },
                error: function(xhr) {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                    
                    // Handle validation errors
                    var errors = xhr.responseJSON?.errors;
                    var errorMessage = '';
                    
                    if (errors) {
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    } else {
                        errorMessage = "{{ __('An error occurred during the upgrade operation.') }}";
                    }
                    
                    Swal.fire({
                        title: "{{ __('Error!') }}",
                        html: errorMessage,
                        icon: "error",
                        confirmButtonClass: "btn btn-primary w-xs mt-2",
                        buttonsStyling: false
                    });
                }
            });
        });
        
        // Initialize List.js for table sorting and search (client-side only)
        try {
            var options = {
                valueNames: [
                    'id',
                    'business_name',
                    'business_category',
                    'business_type',
                    'phone',
                    'package',
                    'last_enroll',
                    'expired_date'
                ],
                page: parseInt($('#per_page').val() || 10),
                pagination: true,
                plugins: [
                    ListPagination({})
                ]
            };
            
            // Initialize List only if not already initialized
            if (document.getElementById('orderTable') && !window.businessList) {
                window.businessList = new List('orderList', options);
                
                // Event handler for no results
                businessList.on('updated', function() {
                    if (businessList.matchingItems.length === 0) {
                        $('.noresult').show();
                    } else {
                        $('.noresult').hide();
                    }
                });
            }
        } catch (error) {
            console.error("List.js initialization error:", error);
        }
    });
</script>
@endsection