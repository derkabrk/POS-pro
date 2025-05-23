@extends('layouts.master')

@section('title')
    {{ __('Subscription Plan')  }}
@endsection

@section('content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card card bg-transparent">
            <div class="card-bodys ">
                <div class="table-header p-16">
                    <h4>{{__('Plan List')}}</h4>
                    @can('plans-create')
                        <a type="button" href="{{route('admin.plans.create')}}" class="add-order-btn rounded-2 {{ Route::is('admin.plans.create') ? 'active' : '' }}" class="btn btn-primary" ><i class="fas fa-plus-circle me-1"></i>{{ __('Create Plans') }}</a>
                    @endcan
                </div>
                <div class="table-top-form p-16-0">
                    <form action="{{ route('admin.plans.filter') }}" method="post" class="filter-form" table="#plans-data">
                        @csrf

                        <div class="table-top-left d-flex gap-3 margin-l-16">
                            <div class="gpt-up-down-arrow position-relative">
                                <select name="per_page" class="form-control">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                                <span></span>
                            </div>

                            <div class="table-search position-relative">
                                <input class="form-control searchInput" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
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

            <div class="table-responsive table-card">
                <table class="table table-nowrap mb-0" id="datatable">
                    <thead class="table-light">
                    <tr>
                        @can('plans-delete')
                            <th>
                                <div class="d-flex align-items-center gap-3">
                                    <label class="table-custom-checkbox">
                                        <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox">
                                        <span class="table-custom-checkmark custom-checkmark"></span>
                                    </label>
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                        @endcan
                        <th>{{ __('SL') }}.</th>
                        <th class="text-start">{{ __('Subscription Name') }}</th>
                        <th>{{ __('Duration') }}</th>
                        <th>{{ __('Offer Price') }}</th>
                        <th>{{ __('Subscription Price') }}</th>
                        <th>{{ __('Permissions') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody id="plans-data" class="searchResults">
                        @foreach($plans as $plan)
                        <tr>
                            @can('plans-delete')
                                <td>
                                    <label class="table-custom-checkbox">
                                        <input type="checkbox" class="table-hidden-checkbox selectRowCheckbox" value="{{ $plan->id }}">
                                        <span class="table-custom-checkmark custom-checkmark"></span>
                                    </label>
                                </td>
                            @endcan
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $plan->subscriptionName }}</td>
                            <td>{{ $plan->duration }}</td>
                            <td>{{ $plan->offerPrice }}</td>
                            <td>{{ $plan->subscriptionPrice }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @if(!empty($plan->permissions) && is_array($plan->permissions))
                                        @foreach($plan->permissions as $permission)
                                            <span class="badge rounded-pill bg-gradient-info text-dark shadow-sm px-3 py-2 mb-1" style="font-size: 0.95em; letter-spacing: 0.02em;">
                                                <i class="fas fa-check-circle me-1 text-primary"></i>{{ __(ucwords(str_replace('_', ' ', $permission))) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted fst-italic">{{ __('None') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($plan->status == 1)
                                    <span class="badge bg-success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                @can('plans-update')
                                    <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                @endcan
                                @can('plans-delete')
                                    <button type="button" class="btn btn-sm btn-danger delete-plan" data-id="{{ $plan->id }}">{{ __('Delete') }}</button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $plans->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
