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
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Count') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $statuses = \App\Models\Sale::STATUS; @endphp
                                            @foreach($statuses as $statusId => $statusArr)
                                                <tr>
                                                    <td>
                                                        <span class="badge {{ $statusArr['color'] }} text-dark">
                                                            {{ $statusArr['name'] }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $user->orderStatusUpdates->where('new_status', $statusId)->count() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
