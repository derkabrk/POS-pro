@foreach($incomes as $income)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $income->id }}">
        </td>
        <td>{{ ($incomes->currentPage() - 1) * $incomes->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ currency_format($income->amount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ $income->category?->categoryName }}</td>
        <td class="text-start">{{ $income->incomeFor }}</td>
        <td class="text-start">{{ $income->payment_type_id != null ? $income->payment_type->name ?? '' : $income->paymentType }}</td>
        <td class="text-start">{{ $income->referenceNo }}</td>
        <td class="text-start">{{ formatted_date($income->incomeDate) }}</td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#incomes-edit-modal" data-bs-toggle="modal" class="incomes-edit-btn"
                        data-url="{{ route('business.incomes.update', $income->id) }}"
                        data-income-category-id="{{ $income->income_category_id }}"
                        data-income-amount="{{ $income->amount }}"
                        data-income-for="{{ $income->incomeFor }}"
                        data-income-payment-type="{{ $income->paymentType }}"
                        data-income-payment-type-id="{{ $income->payment_type_id }}"
                        data-income-reference-no="{{ $income->referenceNo }}"
                        data-income-date-update="{{  \Carbon\Carbon::parse($income->incomeDate)->format('Y-m-d') }}"
                        data-income-note="{{ $income->note }}">
                        <i class="fal fa-pencil-alt"></i>{{ __('Edit') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.incomes.destroy', $income->id) }}" class="confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
