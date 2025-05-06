@extends('business::layouts.master')

@section('title', 'Suppliers')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Suppliers</h4>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                    <i class="fas fa-plus-circle me-1"></i> Add Supplier
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="w-60 checkbox">
                                    <input type="checkbox" id="select-all" class="delete-checkbox-item">
                                </th>
                                <th>#</th>
                                <th>Image</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Total Products</th>
                                <th>Total Products in Stock</th>
                                <th>Products Sold</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suppliersData as $key => $data)
                                <tr>
                                    <td class="w-60 checkbox">
                                        <input type="checkbox" name="ids[]" class="delete-checkbox-item multi-delete" value="{{ $data['supplier']->id }}">
                                    </td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($data['supplier']->image ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="table-product-img">
                                    </td>
                                    <td>{{ $data['supplier']->name }}</td>
                                    <td>{{ $data['supplier']->phone }}</td>
                                    <td>{{ $data['supplier']->email }}</td>
                                    <td>{{ $data['totalProducts'] }}</td>
                                    <td>{{ $data['totalStock'] }}</td>
                                    <td>{{ $data['productsSold'] }}</td>
                                    <td class="print-d-none">
                                        <div class="dropdown table-action">
                                            <button type="button" data-bs-toggle="dropdown">
                                                <i class="far fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#supplier-view" class="supplier-view-btn" data-bs-toggle="modal"
                                                        data-name="{{ $data['supplier']->name }}"
                                                        data-phone="{{ $data['supplier']->phone }}"
                                                        data-email="{{ $data['supplier']->email }}"
                                                        data-total-products="{{ $data['totalProducts'] }}"
                                                        data-total-stock="{{ $data['totalStock'] }}"
                                                        data-products-sold="{{ $data['productsSold'] }}">
                                                        <i class="fal fa-eye"></i> {{ __('View') }}
                                                    </a>
                                                </li>
                                               
                                                
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">No Suppliers Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addSupplierModalLabel">Add New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.suppliers.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Full Name" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center mt-4">
                                <button type="reset" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

