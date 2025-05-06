@extends('layouts.master')

@section('title', 'Suppliers')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>Suppliers</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                        <i class="fas fa-plus-circle me-1"></i> Add Supplier
                    </button>
                </div>
                <div class="responsive-table m-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Total Products</th>
                                <th>Total Products in Stock</th>
                                <th>Products Sold</th>
                                <th>Products Sold (Delivered)</th>
                                <th>Products Sold (Paid)</th>
                                <th>Products Sold (Checkout)</th>
                                <th>Products Sold (Returned)</th>
                                <th>Pending</th>
                                <th>Available</th>
                                <th>Paid</th>
                                <th>Cashout</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suppliersData as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="text-center">No Suppliers Found</td>
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
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Add New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('suppliers.store') }}" method="POST">
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
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="theme-btn m-2">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection