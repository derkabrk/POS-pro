@foreach($incomes as $income)
<tr>
    <td class="w-60 checkbox">
        <input type="checkbox" name="ids[]" class="form-check-input delete-checkbox-item multi-delete" value="{{ $income->id }}">
    </td>
    <td>{{ ($incomes->currentPage() - 1) * $incomes->perPage() + $loop->iteration }}</td>
    <td class="text-start fw-semibold text-primary">{{ currency_format($income->amount, 'icon', 2, business_currency()) }}</td>
    <td class="text-start">{{ $income->category?->categoryName }}</td>
    <td class="text-start">{{ $income->incomeFor }}</td>
    <td class="text-start">
        <span class="badge bg-light text-dark border border-1 border-secondary px-2 py-1">
            {{ $income->payment_type_id != null ? $income->payment_type->name ?? '' : $income->paymentType }}
        </span>
    </td>
    <td class="text-start text-muted">{{ $income->referenceNo }}</td>
    <td class="text-start">{{ formatted_date($income->incomeDate) }}</td>
    <td class="print-d-none">
        <div class="dropdown table-action">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-link p-0 text-secondary">
                <i class="far fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#incomes-edit-modal" data-bs-toggle="modal" class="incomes-edit-btn dropdown-item"
                    data-url="{{ route('business.incomes.update', $income->id) }}"
                    data-income-category-id="{{ $income->income_category_id }}"
                    data-income-amount="{{ $income->amount }}"
                    data-income-for="{{ $income->incomeFor }}"
                    data-income-payment-type="{{ $income->paymentType }}"
                    data-income-payment-type-id="{{ $income->payment_type_id }}"
                    data-income-reference-no="{{ $income->referenceNo }}"
                    data-income-date-update="{{  \Carbon\Carbon::parse($income->incomeDate)->format('Y-m-d') }}"
                    data-income-note="{{ $income->note }}">
                    <i class="fal fa-pencil-alt me-1"></i>{{ __('Edit') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('business.incomes.destroy', $income->id) }}" class="confirm-action dropdown-item" data-method="DELETE">
                        <i class="fal fa-trash-alt me-1"></i>
                        {{ __('Delete') }}
                    </a>
                </li>
            </ul>
        </div>
    </td>
</tr>
@endforeach
