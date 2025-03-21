@foreach ($subscribers as $subscriber)
    <tr>
        <td>{{ ($subscribers->currentPage() - 1) * $subscribers->perPage() + $loop->iteration }}</td>
        <td>{{ formatted_date($subscriber->created_at) }}</td>
        <td>{{ $subscriber->plan->subscriptionName ?? 'N/A' }}</td>
        <td>{{ formatted_date($subscriber->created_at) }}</td>
        <td>{{ $subscriber->created_at ? formatted_date($subscriber->created_at->addDays($subscriber->duration)) : '' }}</td>
        <td>{{ $subscriber->gateway->name ?? 'N/A' }}</td>
        <td>
            <div class="badge bg-{{ $subscriber->payment_status == 'unpaid' ? 'danger' : 'primary' }}">
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
                        <a target="_blank" href="{{ route('business.subscription-reports.invoice', $subscriber->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            {{ __('Invoice') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>

    </tr>
@endforeach

