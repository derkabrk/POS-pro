@foreach($sales as $sale)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item multi-delete" value="{{ $sale->id }}">
        </td>
        <td>{{ $loop->iteration }}</td>
        <td class="text-start">{{ $sale->created_at->format('d M, Y') }}</td>
        <td class="text-start">{{ $sale->invoiceNumber }}</td>
        <td class="text-start">{{ $sale->party->name ?? 'N/A' }}</td>
        <td class="text-start">${{ number_format($sale->totalAmount, 2) }}</td>
        <td class="text-start">{{ $sale->sale_type == 0 ? 'Business' : 'E-commerce' }}</td>
        <td class="text-start">${{ number_format($sale->paidAmount, 2) }}</td>
        <td class="text-start">${{ number_format($sale->dueAmount, 2) }}</td>
        <td class="text-start">{{ $sale->payment_type_id != null ? $sale->payment_type->name ?? '' : $sale->paymentType }}</td>
        @if ($sale->sale_type == 1)
    <td>
    <select name="sale_status" class="form-control">
        @foreach (\App\Models\Sale::STATUS as $id => $status)
            <option value="{{ $id }}" {{ $sale->sale_status == $id ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
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
