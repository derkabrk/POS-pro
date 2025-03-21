@foreach ($subscribers as $subscriber)
    <tr>
        <td>{{ $loop->index + 1 }} <i class="{{ request('id') == $subscriber->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ formatted_date($subscriber->created_at) }}</td>
        <td>{{ $subscriber->business->companyName ?? 'N/A' }}</td>
        <td>{{ optional($subscriber->business->category)->name ?? 'N/A' }}</td>
        <td>{{ $subscriber->plan->subscriptionName ?? 'N/A' }}</td>
        <td>{{ formatted_date($subscriber->created_at) }}</td>
        <td>{{ $subscriber->created_at ? formatted_date($subscriber->created_at->addDays($subscriber->duration)) : '' }}</td>
        <td>{{ $subscriber->gateway->name ?? 'N/A' }}</td>
        <td>
            <div class="badge bg-{{ $subscriber->payment_status == 'reject' ? 'danger' : ($subscriber->payment_status == 'unpaid' ? 'warning' : 'primary') }}">
                {{ ucfirst($subscriber->payment_status) }}
            </div>
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">

                    <li>
                        <a href="#subscriber-view-modal" class="view-btn subscriber-view" data-bs-toggle="modal"
                        data-name="{{ $subscriber->business->companyName ?? 'N/A' }}"
                        data-image="{{ asset($subscriber->business->pictureUrl ?? 'assets/img/default-shop.svg') }}"
                        data-manul-attachment="{{ asset($subscriber->notes['attachment'] ?? '') }}"
                        data-category="{{ optional($subscriber->business->category)->name ?? 'N/A' }}"
                            data-package="{{ $subscriber->plan->subscriptionName ?? 'N/A' }}"
                            data-gateway="{{ $subscriber->gateway->name ?? 'N/A' }}"
                            data-enroll="{{ formatted_date($subscriber->created_at) }}"
                            data-expired="{{  $subscriber->created_at ? formatted_date($subscriber->created_at->addDays($subscriber->duration)) : '' }}"
                        >
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>

                    </li>

                    <li>
                        <a target="_blank" href="{{ route('admin.subscription-reports.invoice', $subscriber->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            {{ __('Invoice') }}
                        </a>
                    </li>

                    @if($subscriber->payment_status == 'unpaid')
                    <li>
                        <a href="#approve-modal" class="modal-approve" data-bs-toggle="modal" data-bs-target="#approve-modal" data-url="{{ route('admin.subscription-reports.paid', $subscriber->id) }}">
                            <i class="fal fa-check"></i>
                            {{ __('Accept') }}
                        </a>
                    </li>
                    <li>
                        <a href="#reject-modal" class="modal-reject" data-bs-toggle="modal" data-bs-target="#reject-modal" data-url="{{ route('admin.subscription-reports.reject', $subscriber->id) }}">
                            <i class="fal fa-times"></i>
                            {{ __('Reject') }}
                        </a>
                    </li>
                    @endif
                </ul>
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
