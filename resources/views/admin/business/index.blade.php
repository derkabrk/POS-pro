@extends('layouts.master')

@section('title')
    {{ __('Business List') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card card bg-transparent">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>{{ __('Business List') }}</h4>
                    @can('business-read')
                     <a type="button" href="{{route('admin.business.create')}}" class="add-order-btn rounded-2 {{ Route::is('admin.business.create') ? 'active' : '' }}" class="btn btn-primary" ><i class="fas fa-plus-circle me-1"></i>{{ __('Add new Business') }}</a>
                    @endcan
                </div>
                <div class="table-top-form p-16-0">
                    <form action="{{ route('admin.business.filter') }}" method="POST" id="filter-form" class="filter-form" table="#business-data">
                        @csrf

                        <div class="table-top-left d-flex gap-3 margin-l-16">
                            <div class="gpt-up-down-arrow position-relative">
                                <select name="per_page" class="form-control">
                                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>{{__('Show- 10')}}</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>{{__('Show- 25')}}</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>{{__('Show- 50')}}</option>
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>{{__('Show- 100')}}</option>
                                </select>
                                <span></span>
                            </div>

                            <div class="gpt-up-down-arrow position-relative">
                                <select name="type" id="sale_type_filter" class="form-control">
                                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                                    <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>{{ __('E-commerce') }}</option>
                                    <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>{{ __('Both') }}</option>
                                    <option value="0" {{ request('type') == '0' ? 'selected' : '' }}>{{ __('Physical') }}</option>
                                </select>
                                <span></span>
                            </div>

                            <div class="table-search position-relative">
                                <input class="form-control searchInput" type="text" name="search"
                                    placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                                <span class="position-absolute">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            
                            <div class="position-relative">
                                <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" name="date_range" placeholder="Select date" value="{{ request('date_range') }}">
                            </div>
                            
                            <div>
                                <button type="submit" class="theme-btn">
                                    <i class="fas fa-filter me-1"></i> {{ __('Filter') }}
                                </button>
                            </div>
                            
                            <div>
                                <a href="{{ route('admin.business.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo-alt me-1"></i> {{ __('Reset') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request('type') == 'all' || !request('type') ? 'active' : '' }}" href="{{ route('admin.business.filter') }}?type=all">
                            <i class="fas fa-store me-1"></i> {{ __('All Businesses') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('type') == '1' ? 'active' : '' }}" href="{{ route('admin.business.filter') }}?type=1">
                            <i class="fas fa-shopping-cart me-1"></i> {{ __('E-commerce') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('type') == '0' ? 'active' : '' }}" href="{{ route('admin.business.filter') }}?type=0">
                            <i class="fas fa-building me-1"></i> {{ __('Physical') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('type') == '2' ? 'active' : '' }}" href="{{ route('admin.business.filter') }}?type=2">
                            <i class="fas fa-store-alt me-1"></i> {{ __('Both') }}
                        </a>
                    </li>
                </ul>

                <div class="table-responsive table-card">
                    <table class="table table-nowrap mb-0" id="datatable">
                        <thead>
                        <tr>
                            <th>
                                <div class="d-flex align-items-center gap-1">
                                    <label class="table-custom-checkbox">
                                        <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox" id="checkAll">
                                        <span class="table-custom-checkmark custom-checkmark"></span>
                                    </label>
                                </div>
                            </th>
                            <th> {{ __('SL') }}. </th>
                            <th> {{ __('Business Name') }} </th>
                            <th> {{ __('Business Category') }} </th>
                            <th> {{ __('Business Type') }} </th>
                            <th> {{ __('Phone') }} </th>
                            <th> {{ __('Package') }} </th>
                            <th> {{ __('Last Enroll') }} </th>
                            <th> {{ __('Expired Date') }} </th>
                            <th> {{ __('Action') }} </th>
                        </tr>
                        </thead>
                        <tbody id="business-data" class="searchResults">
                            @foreach($businesses as $key => $business)
                            <tr>
                                <th scope="row">
                                    <div class="form-check">
                                        <label class="table-custom-checkbox">
                                            <input class="table-hidden-checkbox" type="checkbox" name="checkAll" value="{{ $business->id }}">
                                            <span class="table-custom-checkmark custom-checkmark"></span>
                                        </label>
                                    </div>
                                </th>
                                <td class="id">{{ $loop->iteration }}</td>
                                <td class="business_name">{{ $business->business_name }}</td>
                                <td class="business_category">{{ $business->category->name ?? 'N/A' }}</td>
                                <td class="business_type">
                                    @if($business->type == 0)
                                        <span class="badge bg-info">{{ __('Physical') }}</span>
                                    @elseif($business->type == 1)
                                        <span class="badge bg-primary">{{ __('E-commerce') }}</span>
                                    @else
                                        <span class="badge bg-success">{{ __('Both') }}</span>
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
                                    <div class="btn-group">
                                        <a href="#business-view-modal" class="btn btn-sm btn-info business-view" data-bs-toggle="modal"
                                        data-image="{{ asset($business->pictureUrl ?? 'assets/img/default-shop.svg') }}"
                                        data-name="{{ $business->companyName }}" 
                                        data-address="{{ $business->address }}"
                                        data-category="{{ $business->category->name ?? '' }}"
                                        data-type="{{  $business->type}}"
                                        data-phone="{{ $business->phoneNumber }}"
                                        data-package="{{ $business->enrolled_plan && $business->enrolled_plan->plan ? $business->enrolled_plan->plan->subscriptionName : '' }}"
                                        data-last_enroll="{{ $business->subscriptionDate ? formatted_date($business->subscriptionDate) : '' }}"
                                        data-expired_date="{{ $business->will_expire ? formatted_date($business->will_expire) : '' }}"
                                        data-created_date="{{ $business->created_at ? formatted_date($business->created_at) : '' }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @can('business-update')
                                        <a href="{{ route('admin.business.edit', $business->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        
                                        @can('business-delete')
                                        <a class="btn btn-sm btn-danger delete-btn" data-bs-toggle="modal" 
                                        data-id="{{ $business->id }}" href="#deleteOrder">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endcan
                                        
                                        @can('business-update')
                                        <a class="btn btn-sm btn-success upgrade-plan-btn" data-bs-toggle="modal" 
                                        data-id="{{ $business->id }}"
                                        data-business-name="{{ $business->business_name }}"
                                        href="#business-upgrade-modal">
                                            <i class="fas fa-arrow-circle-up"></i>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($businesses) === 0)
                    <div class="text-center py-4">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="mt-2">{{ __('Sorry! No Result Found') }}</h5>
                        <p class="text-muted">{{ __("We've searched but didn't find any businesses matching your search.") }}</p>
                    </div>
                    @endif
                </div>
                <div class="mt-3">
                    {{ $businesses->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')

    {{-- Business Plan Update modal --}}
    <div class="modal modal-md fade" id="business-upgrade-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content b-radious-24">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Upgrade Plan') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload upgradePlan">
                        @csrf
                        @method('put')

                        <div class="mt-3">
                            <label>{{ __('Business Name') }}</label>
                            <input class="form-control" id="business_name" readonly>
                            <input name="business_id" id="business_id" type="hidden">
                        </div>

                        <div class="mt-3">
                            <label for="plan_id">{{ __('Select A Plan') }}</label>
                            <div class="gpt-up-down-arrow position-relative">
                            <select name="plan_id" id="plan_id" class="form-control">
                                <option value="">{{ __('Select One') }}</option>
                                @foreach ($plans as $plan)
                                    <option data-price="{{ $plan->offerPrice ?? $plan->subscriptionPrice }}" value="{{ $plan->id }}">{{ $plan->subscriptionName }}</option>
                                @endforeach
                            </select>
                            <span></span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label>{{ __('Price') }}</label>
                            <input class="form-control plan-price" name="price" type="number" step="any" placeholder="{{ __('Enter plan price or select a plan') }}">
                        </div>

                        <div class="mt-3">
                            <label>{{ __('Expiry Date') }}</label>
                            <input type="datetime-local" id="datepicker" name="expieryDate" class="form-control">
                        </div>

                        <div class="mt-3">
                            <label>{{ __('Notes') }}</label>
                            <textarea name="notes" id="notes" class="form-control" placeholder="{{ __('Enter notes') }}">{{ 'Plan subscribed by '. auth()->user()->name }}</textarea>
                        </div>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--business view modal --}}
    <div class="modal fade" id="business-view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">{{ __('Business View') }} (<span class="business_name"></span>)</h1>
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
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p class="business_name"></p></div>
                        </div>

                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Business Category') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="category"></p></div>
                        </div>

                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Phone') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="phone"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Address') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="address"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Package') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="package"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Upgrade Date') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="last_enroll"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Expired Date') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="expired_date"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Created date') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="created_date"></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteOrder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                    <div class="mt-4 text-center">
                        <h4>{{ __('You are about to delete a business?') }}</h4>
                        <p class="text-muted fs-15 mb-4">{{ __('Deleting your business will remove all of your information from our database.') }}</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link fw-medium text-decoration-none" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> {{ __('Close') }}
                            </button>
                            <form action="" method="POST" id="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" id="delete-record">
                                    <i class="fas fa-trash me-1"></i> {{ __('Yes, Delete It') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js')
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialize flatpickr for date inputs if available
    if (typeof flatpickr !== 'undefined') {
        flatpickr("[data-provider='flatpickr']", {
            dateFormat: "d M, Y",
            allowInput: true
        });
    }
    
    // Check/uncheck all checkboxes
    $('#checkAll').on('change', function() {
        var isChecked = $(this).prop('checked');
        $('input[name="checkAll"]').prop('checked', isChecked);
    });
    
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
                        confirmButtonClass: "btn btn-primary",
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
                        confirmButtonClass: "btn btn-primary",
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
                    confirmButtonClass: "btn btn-primary",
                    buttonsStyling: false
                });
            }
        });
    });
});
</script>
@endpush