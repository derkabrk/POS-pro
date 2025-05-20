@foreach($plans as $plan)
    <tr class="align-middle">
        @can('plans-delete')
            <td class="w-60 checkbox">
                <label class="table-custom-checkbox">
                    <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $plan->id }}" data-url="{{ route('admin.plans.delete-all') }}">
                    <span class="table-custom-checkmark custom-checkmark"></span>
                </label>
            </td>
        @endcan
        <td>{{ ($plans->perPage() * ($plans->currentPage() - 1)) + $loop->iteration }}</td>
        <td class="text-start">{{ $plan->subscriptionName }}</td>
        <td>{{ $plan->duration }}</td>
        <td class="fw-bold text-dark">{{ $plan->offerPrice ? currency_format($plan->offerPrice) : '' }}</td>
        <td class="fw-bold text-dark">{{ currency_format($plan->subscriptionPrice) }}</td>
        <td class="text-center">
            @can('plans-update')
                <button type="button" class="btn btn-sm btn-icon btn-light status" data-url="{{ route('admin.plans.status', $plan->id)}}" title="{{ $plan->status == 1 ? 'Deactivate' : 'Activate' }}">
                    <span class="badge bg-{{ $plan->status == 1 ? 'success' : 'danger' }} px-2 py-1">{{ $plan->status == 1 ? 'Active' : 'Deactive' }}</span>
                </button>
            @else
                <span class="badge bg-{{ $plan->status == 1 ? 'success' : 'danger' }} px-2 py-1">
                    {{ $plan->status == 1 ? 'Active' : 'Deactive' }}
                </span>
            @endcan
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('plans-update')
                        <li>
                            <a href="{{ route('admin.plans.edit', $plan->id) }}" class="dropdown-item">
                                <i class="fal fa-edit me-1"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('plans-delete')
                        <li>
                            <a href="{{ route('admin.plans.destroy', $plan->id) }}" class="dropdown-item confirm-action" data-method="DELETE">
                                <i class="fal fa-trash-alt me-1"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </td>
    </tr>
@endforeach

