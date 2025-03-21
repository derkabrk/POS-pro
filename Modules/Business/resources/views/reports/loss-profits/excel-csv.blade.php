<table>
    <thead>
        <tr>
            <th>{{ __('SL') }}.</th>
            <th class="text-start">{{ __('Invoice') }}</th>
            <th class="text-start">{{ __('Name') }}</th>
            <th class="text-start">{{ __('Total') }}</th>
            <th class="text-start">{{ __('Loss/Profit') }}</th>
            <th class="text-start">{{ __('Date') }}</th>
            <th class="text-start">{{ __('Status') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($loss_profits as $loss_profit)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td class="text-start">{{ $loss_profit->invoiceNumber }}</td>
                <td class="text-start">{{ $loss_profit->party?->name }}</td>
                <td class="text-start">{{ currency_format($loss_profit->totalAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">
                    @php
                        $amount = abs($loss_profit->lossProfit);
                        $sign = $loss_profit->lossProfit < 0 ? '-' : '';
                    @endphp
                    <span
                        class="{{ $loss_profit->lossProfit < 0 ? 'bg-danger' : 'bg-success' }} text-white px-2 py-1 rounded d-inline-block">
                        {{ $sign . currency_format($amount, 'icon', 2, business_currency()) }}
                    </span>
                </td>

                <td class="text-start">{{ formatted_date($loss_profit->created_at) }}</td>
                <td class="text-start">
                    <span class="{{ $loss_profit->dueAmount == 0 ? 'bg-success text-white px-2 py-1 rounded' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'bg-warning text-white px-2 py-1 rounded' : 'bg-danger text-white px-2 py-1 rounded') }}">
                        {{ $loss_profit->dueAmount == 0 ? 'Paid' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'Partial Paid' : 'Unpaid') }}
                    </span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
