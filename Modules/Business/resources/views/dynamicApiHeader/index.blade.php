@extends('business::layouts.master')

@section('title', 'API Headers')

@section('main_content')
<div class="container">
    <h1>API Headers</h1>
    <a href="{{ route('business.dynamicApiHeader.create') }}" class="btn btn-primary">Create API Header</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>API Key</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apiHeaders as $header)
            <tr>
                <td>{{ $header->id }}</td>
                <td>{{ $header->name }}</td>
                <td>{{ $header->api_key }}</td>
                <td>{{ $header->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('business.dynamicApiHeader.edit', $header->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('business.dynamicApiHeader.destroy', $header->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $apiHeaders->links() }}
</div>
@endsection