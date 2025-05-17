@foreach($loss_profits as $loss_profit)
    <tr>
        <td>{{ ($loss_profits->currentPage() - 1) * $loss_profits->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $loss_profit->invoiceNumber }}</td>
        <td class="text-start">{{ $loss_profit->party?->name }}</td>
        <td class="text-start">{{ currency_format($loss_profit->totalAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">
            @php
                $amount = abs($loss_profit->lossProfit);
                $sign = $loss_profit->lossProfit < 0 ? '-' : '';
            @endphp
            <span class="{{ $loss_profit->lossProfit < 0 ? 'text-danger' : 'text-success' }} px-2 py-1 rounded d-inline-block">
                {{ $sign . currency_format($amount, 'icon', 2, business_currency()) }}
            </span>
        </td>
        <td class="text-start">{{ formatted_date($loss_profit->created_at) }}</td>
        <td class="text-start">
            <span class="{{ $loss_profit->dueAmount == 0 ? 'text-success px-2 py-1 rounded' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'text-warning px-2 py-1 rounded' : 'text-danger px-2 py-1 rounded') }}">
                {{ $loss_profit->dueAmount == 0 ? 'Paid' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'Partial Paid' : 'Unpaid') }}
            </span>
        </td>

    </tr>
@endforeach


