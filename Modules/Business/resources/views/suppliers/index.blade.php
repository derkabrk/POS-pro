@extends('business::layouts.master')

@section('title', 'Supplier List')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>{{ __('Supplier List') }}</h4>
                    <a type="button" href=""
                       class="add-order-btn rounded-2 {{ Route::is('business.suppliers.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle me-1"></i>{{ __('Add New Supplier') }}
                    </a>
                </div>

                <div class="table-top-form p-16-0">
                    <form action="{{ route('business.suppliers.index') }}" method="get" class="filter-form" table="#suppliers-data">
                        <div class="table-top-left d-flex gap-3 margin-l-16">
                            <div class="gpt-up-down-arrow position-relative">
                                <select name="per_page" class="form-control">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>{{ __('Show- 10') }}</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>{{ __('Show- 25') }}</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>{{ __('Show- 50') }}</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>{{ __('Show- 100') }}</option>
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
                        </div>
                    </form>
                </div>

                <div class="responsive-table m-0">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th class="w-60">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" class="select-all-delete multi-delete">
                                    </div>
                                </th>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Total Products') }}</th>
                                <th>{{ __('Total Stock') }}</th>
                                <th>{{ __('Products Sold') }}</th>
                                <th>{{ __('Products Sold (Delivered)') }}</th>
                                <th>{{ __('Products Sold (Paid)') }}</th>
                                <th>{{ __('Products Sold (Checkout)') }}</th>
                                <th>{{ __('Products Sold (Returned)') }}</th>
                                <th>{{ __('Pending') }}</th>
                                <th>{{ __('Available') }}</th>
                                <th>{{ __('Paid') }}</th>
                                <th>{{ __('Cashout') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="suppliers-data">
                            @forelse ($suppliersData as $key => $data)
                                <tr>
                                    <td class="w-60">
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="checkbox" name="ids[]" class="delete-checkbox-item multi-delete" value="{{ $data['supplier']->id }}">
                                        </div>
                                    </td>
                                    <td>{{ $loop->iteration + ($suppliers->currentPage() - 1) * $suppliers->perPage() }}</td>
                                    <td>
                                        <img src="{{ asset($data['supplier']->image ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="table-product-img">
                                    </td>
                                    <td>{{ $data['supplier']->name }}</td>
                                    <td>{{ $data['supplier']->phone }}</td>
                                    <td>{{ $data['supplier']->email }}</td>
                                    <td>{{ $data['totalProducts'] }}</td>
                                    <td>{{ $data['totalStock'] }}</td>
                                    <td>{{ $data['productsSold'] }}</td>
                                    <td>{{ $data['productsDelivered'] }}</td>
                                    <td>{{ $data['productsPaid'] }}</td>
                                    <td>{{ $data['productsCheckout'] }}</td>
                                    <td>{{ $data['productsReturned'] }}</td>
                                    <td>{{ $data['pending'] }}</td>
                                    <td>{{ $data['available'] }}</td>
                                    <td>{{ $data['paid'] }}</td>
                                    <td>{{ $data['cashout'] }}</td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <button type="button" data-bs-toggle="dropdown">
                                                <i class="far fa-ellipsis-v"></i>
                                            </button>
                                           
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="18" class="text-center text-muted">{{ __('No Suppliers Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $suppliers->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
@endpush

