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
                <form action="{{ route('admin.business.filter_business') }}" method="POST" id="filter-form" class="filter-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" data-choices data-choices-search-false name="type" id="sale_type_filter">
                                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                                    <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>{{ __('E-commerce') }}</option>
                                    <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>{{ __('Both') }}</option>
                                    <option value="0" {{ request('type') == '0' ? 'selected' : '' }}>{{ __('Physical') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <button type="submit" class="btn btn-primary w-100" id="filter-button"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    {{ __('Filter by Type') }}
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
                                @include('admin.business.dates')
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $businesses->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
                        </div>
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
<script>
    $(document).ready(function() {
        // Only initialize flatpickr and Choices.js for UI enhancement, not for filtering
        if (typeof flatpickr !== 'undefined') {
            flatpickr("[data-provider='flatpickr']", {
                dateFormat: "d M, Y",
                allowInput: true
            });
        }
        document.querySelectorAll("[data-choices]").forEach(element => {
            if (!element.classList.contains('choices__input') && !element.classList.contains('choices__inner') && !element.parentElement.classList.contains('choices')) {
                new Choices(element, {
                    searchEnabled: !(element.getAttribute("data-choices-search-false") === "true"),
                    itemSelectText: '',
                });
            }
        });
    });
</script>
@include('admin.business.dates')
@endsection