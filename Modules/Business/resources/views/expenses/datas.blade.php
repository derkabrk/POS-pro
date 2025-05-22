@foreach($expenses as $expense)
    <tr class="admin-table-row">
        <td class="admin-table-cell admin-checkbox">
            <input type="checkbox" name="ids[]" class="admin-checkbox-item multi-delete" value="{{ $expense->id }}">
        </td>
        <td class="admin-table-cell">{{ ($expenses->currentPage() - 1) * $expenses->perPage() + $loop->iteration }}</td>
        <td class="admin-table-cell text-start">{{ currency_format($expense->amount, 'icon', 2, business_currency()) }}</td>
        <td class="admin-table-cell text-start">{{ $expense->category?->categoryName }}</td>
        <td class="admin-table-cell text-start">{{ $expense->expanseFor }}</td>
        <td class="admin-table-cell text-start">{{ $expense->payment_type_id != null ? $expense->payment_type->name ?? '' : $expense->paymentType }}</td>
        <td class="admin-table-cell text-start">{{ $expense->referenceNo }}</td>
        <td class="admin-table-cell text-start">{{ formatted_date($expense->expenseDate) }}</td>
        <td class="admin-table-cell print-d-none">
            <div class="admin-dropdown table-action">
                <button type="button" data-bs-toggle="dropdown" class="admin-dropdown-toggle">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="admin-dropdown-menu">
                    <li>
                        <a href="#expenses-edit-modal" data-bs-toggle="modal" class="expense-edit-btn admin-dropdown-item"
                           data-url="{{ route('business.expenses.update', $expense->id) }}"
                           data-expense-category-id="{{ $expense->expense_category_id }}"
                           data-expense-amount="{{ $expense->amount }}"
                           data-expense-for="{{ $expense->expanseFor }}"
                           data-expense-payment-type="{{ $expense->paymentType }}"
                           data-expense-payment-type-id="{{ $expense->payment_type_id }}"
                           data-expense-reference-no="{{ $expense->referenceNo }}"
                           data-expense-date="{{ \Carbon\Carbon::parse($expense->exoenseDate)->format('Y-m-d') }}"
                           data-expense-note="{{ $expense->note }}">
                           <i class="fal fa-pencil-alt"></i>{{ __('Edit') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.expenses.destroy', $expense->id) }}" class="confirm-action admin-dropdown-item" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
