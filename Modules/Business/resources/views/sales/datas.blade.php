@foreach($sales as $sale)
    <tr>
        <th scope="row">
            <div class="form-check">
                <input class="form-check-input delete-checkbox-item multi-delete" type="checkbox" name="ids[]" value="{{ $sale->id }}">
            </div>
        </th>
        <td class="sl">{{ $loop->iteration }}</td>
        <td class="date">{{ $sale->created_at->format('d M, Y') }}, <small class="text-muted">{{ $sale->created_at->format('h:i A') }}</small></td>
        <td class="tracking">
            @if($sale->tracking_id)
                <a href="{{ route('business.sales.showOrder', $sale->id) }}" class="fw-medium link-primary">#{{ $sale->tracking_id }}</a>
            @else
                <span class="text-muted">N/A</span>
            @endif
        </td>
        <td class="party_name">{{ $sale->party->name ?? 'N/A' }}</td>
        <td class="total">${{ number_format($sale->totalAmount, 2) }}</td>
        <td class="sale_type">
            @if($sale->sale_type == 0)
                <span class="badge bg-success-subtle text-success text-uppercase">Physical</span>
            @else
                <span class="badge bg-info-subtle text-info text-uppercase">E-commerce</span>
            @endif
        </td>
        <td class="delivery_type">
            @if($sale->sale_type == 0)
                <span class="badge bg-secondary-subtle text-secondary text-uppercase">Physical</span>
            @else
                @if($sale->delivery_type == 0)
                    <span class="badge bg-primary-subtle text-primary text-uppercase">Home Delivery</span>
                @else
                    <span class="badge bg-warning-subtle text-warning text-uppercase">StepDesk</span>
                @endif
            @endif
        </td>
        <td class="payment">${{ number_format($sale->dueAmount, 2) }}</td>
        <td class="status">
            @if ($sale->sale_type == 1) 
                @php
                    $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                    $disabledStatuses = ['Cash Out', 'Canceled'];
                    
                    // Map status colors to badge classes
                    $badgeClass = match($status['color']) {
                        'bg-success' => 'bg-success-subtle text-success',
                        'bg-warning' => 'bg-warning-subtle text-warning',
                        'bg-danger' => 'bg-danger-subtle text-danger',
                        'bg-info' => 'bg-info-subtle text-info',
                        'bg-primary' => 'bg-primary-subtle text-primary',
                        default => 'bg-secondary-subtle text-secondary'
                    };
                @endphp
                
                @if(in_array($status['name'], $disabledStatuses))
                    <span class="badge {{ $badgeClass }} text-uppercase">{{ $status['name'] }}</span>
                @else
                    <button 
                        class="badge {{ $badgeClass }} text-uppercase border-0 status-btn"
                        style="cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#updateStatusModal"
                        data-sale-id="{{ $sale->id }}"
                        data-current-status="{{ $sale->sale_status }}"
                        data-redirect-from="orders_table"
                    >
                        {{ $status['name'] }}
                    </button>
                @endif
            @else
                <span class="badge bg-success-subtle text-success text-uppercase">Completed</span>
            @endif
        </td>
        <td class="action">
            <ul class="list-inline hstack gap-2 mb-0">
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ __('View Invoice') }}">
                    <a href="{{ route('business.sales.invoice', $sale->id) }}" target="_blank" class="text-primary d-inline-block">
                        <i class="ri-file-text-line fs-16"></i>
                    </a>
                </li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ __('Show Order') }}">
                    <a href="{{ route('business.sales.showOrder', $sale->id) }}" target="_blank" class="text-info d-inline-block">
                        <i class="ri-eye-fill fs-16"></i>
                    </a>
                </li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ __('Sales Return') }}">
                    <a href="{{ route('business.sale-returns.create', ['sale_id' => $sale->id]) }}" class="text-warning d-inline-block">
                        <i class="ri-arrow-go-back-line fs-16"></i>
                    </a>
                </li>
                <li class="list-inline-item dropdown">
                    <a class="text-muted dropdown-toggle fs-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-fill"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('business.sales.invoice', $sale->id) }}" target="_blank">
                            <i class="ri-file-text-line align-bottom me-2 text-muted"></i> {{ __('Invoice') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('business.sales.showOrder', $sale->id) }}" target="_blank">
                            <i class="ri-eye-line align-bottom me-2 text-muted"></i> {{ __('Show Order') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('business.sale-returns.create', ['sale_id' => $sale->id]) }}">
                            <i class="ri-arrow-go-back-line align-bottom me-2 text-muted"></i> {{ __('Sales Return') }}
                        </a>
                    </div>
                </li>
            </ul>
        </td>
    </tr>
@endforeach

@push('modal')
    @include('business::sales.update-status')
@endpush

<style>
.status-btn {
    background: none !important;
    border: none !important;
    padding: 0.25rem 0.5rem !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    border-radius: 0.25rem !important;
    transition: all 0.15s ease-in-out;
}

.status-btn:hover {
    opacity: 0.8;
    transform: translateY(-1px);
}

.status-btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>