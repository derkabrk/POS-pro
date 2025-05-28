@extends('business::layouts.master')

@section('title')
    {{__('Roles')}}
@endsection

@section('content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card bg-transparent">
            <div class="card-body">
                <div class="table-header p-16">
                    <h4>{{__('User Roles & Statistics')}}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>{{ __('User Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Order Status Updates') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name ?? '-' }}</td>
                                <td>
                                    @if($user->orderStatusUpdates && $user->orderStatusUpdates->count())
                                        <ul class="list-unstyled mb-0">
                                            @foreach($user->orderStatusUpdates->groupBy('new_status') as $status => $updates)
                                                <li>
                                                    <span class="badge bg-info text-dark">{{ $status }}</span>:
                                                    {{ $updates->count() }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('business.roles.edit', $user->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                    <a href="{{ route('business.roles.destroy', $user->id) }}" class="btn btn-sm btn-danger confirm-action" data-method="DELETE">{{ __('Delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('business.roles.create') }}" class="btn btn-warning fw-bold btn-sm">{{ __('Add User Role') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
