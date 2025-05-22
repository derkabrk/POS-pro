@extends('business::layouts.master')

@section('title', 'Supplier List')

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card bg-light">
            <div class="card-body">
                <div class="table-header d-flex justify-content-between align-items-center p-3">
                    <h4 class="mb-0">{{ __('Supplier List') }}</h4>
                    <a type="button" href="{{ route('business.parties.create', ['type' => 'supplier']) }}"
                       class="btn btn-primary rounded-pill {{ Route::is('business.suppliers.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle me-1"></i>{{ __('Add New Supplier') }}
                    </a>
                </div>

                <div class="table-top-form p-3">
                    <form action="{{ route('business.suppliers.index') }}" method="get" class="d-flex align-items-center gap-3" table="#suppliers-data">
                        <div class="form-group mb-0">
                            <select name="per_page" class="form-select">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>{{ __('Show- 10') }}</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>{{ __('Show- 25') }}</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>{{ __('Show- 50') }}</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>{{ __('Show- 100') }}</option>
                            </select>
                        </div>

                        <div class="form-group mb-0 position-relative">
                            <input class="form-control" type="text" name="search"
                                   placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" class="form-check-input select-all-delete multi-delete">
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
                                    <td class="text-center">
                                        <input type="checkbox" name="ids[]" class="form-check-input delete-checkbox-item multi-delete" value="{{ $data['supplier']->id }}">
                                    </td>
                                    <td>{{ $loop->iteration + ($suppliers->currentPage() - 1) * $suppliers->perPage() }}</td>
                                    <td>
                                        <img src="{{ asset($data['supplier']->image ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="img-thumbnail" style="width: 50px; height: 50px;">
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
                                        <button class="btn btn-sm btn-success">{{ __('Pay Me') }}</button>
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

