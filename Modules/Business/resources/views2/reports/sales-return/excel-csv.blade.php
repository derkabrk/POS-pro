<table>
    <thead>
        <tr>
            <th>{{ __('SL') }}.</th>
            <th>{{ __('Invoice No') }}</th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Total') }}</th>
            <th>{{ __('Paid') }}</th>
            <th>{{ __('Return Amount') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sales as $sale)
        <td>
            @php
                $total_return_amount = $sale->saleReturns->sum('total_return_amount');
            @endphp
        </td>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <a href="{{ route('business.sales.invoice', $sale->id) }}" target="_blank" class="text-primary">
                    {{ $sale->invoiceNumber }}
                </a>
            </td>
            <td>{{ formatted_date($sale->saleDate) }}</td>
            <td>{{ $sale->party->name ?? 'Guest' }}</td>

            <td>{{ $sale->totalAmount }}</td>
            <td>{{ $sale->paidAmount }}</td>
            <td>{{ currency_format($total_return_amount ?? 0, 'icon', 2, business_currency()) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
