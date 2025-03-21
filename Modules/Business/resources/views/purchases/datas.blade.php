@foreach($purchases as $purchase)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $purchase->id }}">
        </td>
        <td>{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ formatted_date($purchase->purchaseDate) }}</td>
        <td class="text-start">{{ $purchase->invoiceNumber }}</td>
        <td class="text-start">{{ $purchase->party->name }}</td>
        <td class="text-start">{{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($purchase->discountAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($purchase->dueAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}</td>
        <td>
            <div class="{{ $purchase->dueAmount == 0 ? 'paid-badge' : ($purchase->dueAmount > 0 && $purchase->dueAmount < $purchase->totalAmount ? 'unpaid-badge' : 'unpaid-badge-2') }}">
                {{ $purchase->dueAmount == 0 ? 'Paid' : ($purchase->dueAmount > 0 && $purchase->dueAmount < $purchase->totalAmount ? 'Partial Paid' : 'Unpaid') }}
            </div>
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="{{ route('business.purchases.invoice', $purchase->id) }}">
                            <img src="{{ asset('assets/images/icons/Invoic.svg') }}" alt="" >
                            {{ __('Invoice') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.purchase-returns.create', ['purchase_id' => $purchase->id]) }}">
                            <i class="fal fa-undo-alt"></i>
                            {{ __('Purchase Return') }}
                        </a>
                    </li>
                    @if(!in_array($purchase->id, $purchasesWithReturns))
                        <li>
                            <a href="{{ route('business.purchases.edit', $purchase->id) }}">
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('business.purchases.destroy', $purchase->id) }}" class="confirm-action"
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
