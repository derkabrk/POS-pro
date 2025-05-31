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
                <form method="GET" action="" id="role-date-filter-form">
                    <div class="row mb-3">
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select class="form-control" name="date_filter" id="date_filter">
                                    <option value="">{{ __('All Dates') }}</option>
                                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>{{ __('Today') }}</option>
                                    <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>{{ __('Yesterday') }}</option>
                                    <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>{{ __('Last Week') }}</option>
                                    <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>{{ __('Last Month') }}</option>
                                    <option value="last_year" {{ request('date_filter') == 'last_year' ? 'selected' : '' }}>{{ __('Last Year') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
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
                                                @php
                                                    // Extract the color from the btn btn-outline-* class and convert to bg-* for solid color
                                                    $colorClass = str_replace('btn btn-outline-', 'bg-', $statusArr['color']);
                                                    // Add opacity utility if using Bootstrap 5+ (e.g., bg-primary bg-opacity-25)
                                                    $opacityClass = 'bg-opacity-25';
                                                    // Remove 'update-status-btn' if present
                                                    $colorClass = str_replace('update-status-btn', '', $colorClass);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <span class="badge {{ trim($colorClass) }} {{ $opacityClass }} text-dark">
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
<script>
    document.getElementById('date_filter').addEventListener('change', function() {
        document.getElementById('role-date-filter-form').submit();
    });
</script>
@endsection
