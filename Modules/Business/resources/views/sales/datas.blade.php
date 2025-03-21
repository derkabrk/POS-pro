@foreach ($sales as $sale)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $sale->id }}">
        </td>
        <td>{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ formatted_date($sale->saleDate) }}</td>
        <td class="text-start">{{ $sale->invoiceNumber }}</td>
        <td class="text-start">{{ $sale->party->name ?? 'Guest' }}</td>
        <td class="text-start">{{ currency_format($sale->totalAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($sale->discountAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($sale->paidAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($sale->dueAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ $sale->payment_type_id != null ? $sale->payment_type->name ?? '' : $sale->paymentType }}</td>
        <td>
            <div class="{{ $sale->dueAmount == 0 ? 'paid-badge' : ($sale->dueAmount > 0 && $sale->dueAmount < $sale->totalAmount ? 'unpaid-badge' : 'unpaid-badge-2') }}">
                {{ $sale->dueAmount == 0 ? 'Paid' : ($sale->dueAmount > 0 && $sale->dueAmount < $sale->totalAmount ? 'Partial Paid' : 'Unpaid') }}
            </div>
        </td>

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="{{ route('business.sales.invoice', $sale->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="">
                            {{ __('Invoice') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('business.sale-returns.create', ['sale_id' => $sale->id]) }}">
                            <i class="fal fa-undo-alt"></i>
                            {{ __('Sales Return') }}
                        </a>
                    </li>
                    @if(!in_array($sale->id, $salesWithReturns))
                        <li>
                            <a href="{{ route('business.sales.edit', $sale->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                    <li>
                        <a href="{{ route('business.sales.destroy', $sale->id) }}" class="confirm-action"
                            data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </td>
    </tr>
@endforeach
