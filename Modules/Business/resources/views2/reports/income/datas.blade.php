@foreach($income_reports as $income_report)
    <tr>
        <td>{{ ($income_reports->currentPage() - 1) * $income_reports->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ currency_format($income_report->amount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ $income_report->category->categoryName }}</td>
        <td class="text-start">{{ $income_report->incomeFor }}</td>
        <td class="text-start">{{ $income_report->payment_type_id != null ? $income_report->payment_type->name ?? '' : $income_report->paymentType }}</td>
        <td class="text-start">{{ $income_report->referenceNo }}</td>
        <td class="text-start">{{ formatted_date($income_report->incomeDate) }}</td>
    </tr>
@endforeach
