@foreach($sales as $sale)
    <tr class="admin-table-row">
        <td class="admin-table-cell w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item multi-delete" value="{{ $sale->id }}">
        </td>
        <td class="admin-table-cell">{{ $loop->iteration }}</td>
        <td class="admin-table-cell text-start">{{ $sale->created_at->format('d M, Y') }}</td>
        <td class="admin-table-cell text-start">{{ $sale->tracking_id ?? 'N/A'}}</td>
        <td class="admin-table-cell text-start">{{ $sale->party->name ?? 'N/A' }}</td>
        <td class="admin-table-cell text-start">${{ number_format($sale->totalAmount, 2) }}</td>
        <td class="admin-table-cell text-start">{{ $sale->sale_type == 0 ? 'Physical' : 'E-commerce' }}</td>
        <td class="admin-table-cell text-start">
            {{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}
        </td>
        <td class="admin-table-cell text-start">${{ number_format($sale->dueAmount, decimals: 2) }}</td>
        @if ($sale->sale_type == 1) 
        @php
            $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
            $disabledStatuses = ['Cash Out', 'Canceled']; // List of statuses to disable the button
        @endphp
        <td class="admin-table-cell">
            <button 
                class="admin-button {{ $status['color'] }}"
                style="color: {{ $status['text_color'] }}; font-weight: w600;"
                data-bs-toggle="modal"
                data-bs-target="#updateStatusModal"
                data-sale-id="{{ $sale->id }}"
                data-current-status="{{ $sale->sale_status }}"
                data-redirect-from="orders_table"
                {{ in_array($status['name'], $disabledStatuses) ? 'disabled' : '' }} 
            >
                {{ $status['name'] }}
            </button>
        </td>
    @endif
    

        <td class="admin-table-cell print-d-none">
            <div class="dropdown table-action">
                <button type="button" class="admin-dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu admin-dropdown-menu">
                    <li class="admin-dropdown-item">
                        <a target="_blank" href="{{ route('business.sales.invoice', $sale->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            Invoice
                        </a>
                    </li>

                   <li class="admin-dropdown-item">
    <a target="_blank" href="{{ route('business.sales.showOrder', $sale->id) }}">
        <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
        Show Order
    </a>
</li>

                    <li class="admin-dropdown-item">
                        <a href="{{ route('business.sale-returns.create', ['sale_id' => $sale->id]) }}">
                            <i class="fal fa-undo-alt"></i>
                            Sales Return
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>

   
@endforeach


@push('modal')
    @include('business::sales.update-status')
@endpush





