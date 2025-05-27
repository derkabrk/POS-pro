<tbody id="business-data">
@forelse($businesses as $key => $business)
<tr>
    <th scope="row">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="checkAll" value="{{ $business->id }}">
        </div>
    </th>
    <td class="id">{{ $loop->iteration }}</td>
    <td class="business_name">{{ $business->companyName ?? 'N/A' }}</td>
    <td class="business_category">{{ $business->category->name ?? 'N/A' }}</td>
    <td class="business_type">
        @if($business->type == 0)
            <span class="badge bg-info-subtle text-info">{{ __('Physical') }}</span>
        @elseif($business->type == 1)
            <span class="badge bg-primary-subtle text-primary">{{ __('E-commerce') }}</span>
        @else
            <span class="badge bg-success-subtle text-success">{{ __('Both') }}</span>
        @endif
    </td>
    <td class="phone">{{ $business->phoneNumber ?? 'N/A' }}</td>
    <td class="package">
        {{ optional(optional($business->getCurrentPackage)->plan)->subscriptionName ?? 'N/A' }}
    </td>
    <td class="last_enroll">
        {{ optional($business->getCurrentPackage)->created_at ? optional($business->getCurrentPackage)->created_at->format('d M, Y') : 'N/A' }}
    </td>
    <td class="expired_date">
        {{ $business->will_expire ? \Carbon\Carbon::parse($business->will_expire)->format('d M, Y') : 'N/A' }}
    </td>
    <td class="user_points">
        {{ $business->user->points ?? '0' }}
    </td>
    <td>
        <ul class="list-inline hstack gap-2 mb-0">
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#business-view-modal" 
                   data-business-id="{{ $business->id }}"
                   data-business-name="{{ $business->business_name }}"
                   data-category="{{ $business->category->name ?? 'N/A' }}"
                   data-phone="{{ $business->user->phone ?? 'N/A' }}"
                   data-address="{{ $business->address ?? 'N/A' }}"
                   data-package="{{ $business->getCurrentPackage && $business->getCurrentPackage->plan ? $business->getCurrentPackage->plan->subscriptionName : 'N/A' }}"
                   data-last-enroll="{{ $business->getCurrentPackage && $business->getCurrentPackage->created_at ? $business->getCurrentPackage->created_at->format('d M, Y') : 'N/A' }}"
                   data-expired-date="{{ $business->getCurrentPackage && $business->getCurrentPackage->expieryDate ? $business->getCurrentPackage->expieryDate->format('d M, Y') : 'N/A' }}"
                   data-created-date="{{ $business->created_at ? $business->created_at->format('d M, Y') : 'N/A' }}"
                   data-image="{{ asset($business->image) }}"
                   class="text-primary d-inline-block view-btn">
                    <i class="ri-eye-fill fs-16"></i>
                </a>
            </li>
            @can('business-update')
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                <a href="{{ route('admin.business.edit', $business->id) }}" class="text-primary d-inline-block edit-item-btn">
                    <i class="ri-pencil-fill fs-16"></i>
                </a>
            </li>
            @endcan
            @can('business-delete')
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                <a class="text-danger d-inline-block remove-item-btn delete-btn" data-bs-toggle="modal" 
                   data-id="{{ $business->id }}" href="#deleteOrder">
                    <i class="ri-delete-bin-5-fill fs-16"></i>
                </a>
            </li>
            @endcan
            @can('business-update')
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Upgrade Plan">
                <a class="text-success d-inline-block upgrade-plan-btn" data-bs-toggle="modal" 
                   data-id="{{ $business->id }}"
                   data-business-name="{{ $business->business_name }}"
                   href="#business-upgrade-modal">
                    <i class="ri-arrow-up-circle-fill fs-16"></i>
                </a>
            </li>
            @endcan
        </ul>
    </td>
</tr>
@empty
<tr>
    <td colspan="11" class="text-center">{{ __('No results found.') }}</td>
</tr>
@endforelse
</tbody>
<div class="d-flex justify-content-end mt-3">
    {{ $businesses->links('vendor.pagination.bootstrap-5') }}
</div>
