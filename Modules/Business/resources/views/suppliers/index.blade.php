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

