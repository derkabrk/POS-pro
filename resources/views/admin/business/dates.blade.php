@foreach($businesses as $key => $business)
<tr>
    <th scope="row">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="checkAll" value="{{ $business->id }}">
        </div>
    </th>
    <td class="id">{{ $loop->iteration }}</td>
    <td class="business_name">{{ $business->business_name }}</td>
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
    <td class="phone">{{ $business->user->phone ?? 'N/A' }}</td>
    <td class="package">
        {{ $business->enrolled_plan && $business->enrolled_plan->plan ? $business->enrolled_plan->plan->subscriptionName : '' }}
    </td>
    <td class="last_enroll">
        {{ $business->subscriptionDate ? formatted_date($business->subscriptionDate) : '' }}
    </td>
    <td class="expired_date">
        {{ $business->will_expire ? formatted_date($business->will_expire) : '' }}
    </td>
    <td>
        <ul class="list-inline hstack gap-2 mb-0">
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                <a href="#business-view-modal" class="text-primary d-inline-block view-btn business-view" data-bs-toggle="modal"
                   data-image="{{ asset($business->pictureUrl ?? 'assets/img/default-shop.svg') }}"
                   data-name="{{ $business->companyName }}" data-address="{{ $business->address }}"
                   data-category="{{ $business->category->name ?? '' }}"
                   data-type="{{  $business->type}}"
                   data-phone="{{ $business->phoneNumber }}"
                   data-package="{{ $business->enrolled_plan && $business->enrolled_plan->plan ? $business->enrolled_plan->plan->subscriptionName : '' }}"
                   data-last_enroll="{{ $business->subscriptionDate ? formatted_date($business->subscriptionDate) : '' }}"
                   data-expired_date="{{ $business->will_expire ? formatted_date($business->will_expire) : '' }}"
                   data-created_date="{{ $business->created_at ? formatted_date($business->created_at) : '' }}">
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
@endforeach
