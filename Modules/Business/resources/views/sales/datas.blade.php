@foreach($sales as $sale)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item multi-delete" value="{{ $sale->id }}">
        </td>
        <td>{{ $loop->iteration }}</td>
        <td class="text-start">{{ $sale->created_at->format('d M, Y') }}</td>
        <td class="text-start">{{ $sale->tracking_id ?? 'N/A'}}</td>
        <td class="text-start">{{ $sale->party->name ?? 'N/A' }}</td>
        <td class="text-start">${{ number_format($sale->totalAmount, 2) }}</td>
        <td class="text-start">{{ $sale->sale_type == 0 ? 'Physical' : 'E-commerce' }}</td>
        <td class="text-start">
            {{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}
        </td>
        <td class="text-start">${{ number_format($sale->dueAmount, decimals: 2) }}</td>
        @if ($sale->sale_type == 1) 
        @php
            $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
            $disabledStatuses = ['Cash Out', 'Canceled']; // List of statuses to disable the button
        @endphp
        <td>
            <button 
                class="btn btn-sm {{ $status['color'] }} text-white px-2 py-1 rounded-pill update-status-btn"
                data-bs-toggle="modal"
                data-bs-target="#updateStatusModal"
                data-sale-id="{{ $sale->id }}"
                data-current-status="{{ $sale->sale_status }}"
                {{ in_array($status['name'], $disabledStatuses) ? 'disabled' : '' }} 
            >
                {{ $status['name'] }}
            </button>
        </td>
    @endif
    

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="{{ route('business.sales.invoice', $sale->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            Invoice
                        </a>
                    </li>
                    <li>
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





