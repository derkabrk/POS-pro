@foreach ($subscribers as $subscriber)
<tr>
    <td>{{ $loop->index + 1 }} <i class="{{ request('id') == $subscriber->id ? 'fas fa-bell text-red' : '' }}"></i></td>
    <td>{{ formatted_date($subscriber->created_at) }}</td>
    <td>{{ $subscriber->business->companyName ?? 'N/A' }}</td>
    <td>{{ optional($subscriber->business->category)->name ?? 'N/A' }}</td>
    <td>{{ $subscriber->plan->subscriptionName ?? 'N/A' }}</td>
    <td>{{ formatted_date($subscriber->created_at) }}</td>
    <td>{{ $subscriber->created_at ? formatted_date($subscriber->created_at->addDays($subscriber->duration)) : '' }}</td>
    <td>{{ $subscriber->gateway->name ?? 'N/A' }}</td>
    <td>
        <span class="badge bg-{{ $subscriber->payment_status == 'reject' ? 'danger' : ($subscriber->payment_status == 'unpaid' ? 'warning' : 'primary') }}">
            {{ ucfirst($subscriber->payment_status) }}
        </span>
    </td>
    <td class="print-d-none">
        <div class="d-flex gap-2">
            <a href="#subscriber-view-modal" class="btn btn-sm btn-icon btn-outline-info view-btn subscriber-view" data-bs-toggle="modal"
                data-name="{{ $subscriber->business->companyName ?? 'N/A' }}"
                data-image="{{ asset($subscriber->business->pictureUrl ?? 'assets/img/default-shop.svg') }}"
                data-manul-attachment="{{ asset($subscriber->notes['attachment'] ?? '') }}"
                data-category="{{ optional($subscriber->business->category)->name ?? 'N/A' }}"
                data-package="{{ $subscriber->plan->subscriptionName ?? 'N/A' }}"
                data-gateway="{{ $subscriber->gateway->name ?? 'N/A' }}"
                data-enroll="{{ formatted_date($subscriber->created_at) }}"
                data-expired="{{  $subscriber->created_at ? formatted_date($subscriber->created_at->addDays($subscriber->duration)) : '' }}"
                title="View">
                <i class="fal fa-eye"></i>
            </a>
            <a target="_blank" href="{{ route('admin.subscription-reports.invoice', $subscriber->id) }}" class="btn btn-sm btn-icon btn-outline-secondary" title="Invoice">
                <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
            </a>
            @if($subscriber->payment_status == 'unpaid')
                <a href="#approve-modal" class="btn btn-sm btn-icon btn-outline-success modal-approve" data-bs-toggle="modal" data-bs-target="#approve-modal" data-url="{{ route('admin.subscription-reports.paid', $subscriber->id) }}" title="Approve">
                    <i class="fas fa-check"></i>
                </a>
            @endif
        </div>
    </td>
</tr>
@endforeach

<div class="modal fade" id="reject-modal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Why are you reject It?') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="" method="post" enctype="multipart/form-data"
                        class="add-brand-form pt-0 ajaxform_instant_reload modalRejectForm">
                        @csrf
                        <div class="row">
                            <div class="mt-3">
                                <label class="custom-top-label">{{ __('Enter Reason') }}</label>
                               <textarea name="notes" rows="2" class="form-control" placeholder="{{ __('Enter reason') }}"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <a href="" class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
