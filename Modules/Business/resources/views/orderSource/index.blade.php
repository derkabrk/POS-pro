@extends('business::layouts.master')

@section('title')
    Order Sources
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Order Sources List</h4>
                   
                    <a type="button" href="{{ route('business.orderSource.create') }}" class="add-order-btn rounded-2 btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i>Add New Order Source
                    </a>
                </div>
            </div>

            <div class="responsive-table m-0">
                <table class="table" id="datatable">
                    <thead>
                    <tr>
                        <th>{{ __('SL') }}.</th>
                        <th class="text-start">Name</th>
                        <th class="text-start">API Key</th>
                        <th class="text-start">Status</th>
                        <th class="text-start">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderSources as $key => $orderSource)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $orderSource->name }}</td>
                            <td>{{ $orderSource->api_key }}</td>
                            <td>{{ $orderSource->status ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('business.orderSource.edit', $orderSource->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('business.orderSource.destroy', $orderSource->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $orderSources->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection