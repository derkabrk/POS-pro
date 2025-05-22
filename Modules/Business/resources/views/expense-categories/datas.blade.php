@foreach($expense_categories as $expense_category)
    <tr class="admin-table-row">
        <td class="admin-table-cell admin-checkbox">
            <input type="checkbox" name="ids[]" class="admin-checkbox-item multi-delete" value="{{ $expense_category->id }}">
        </td>
        <td class="admin-table-cell">{{ ($expense_categories->currentPage() - 1) * $expense_categories->perPage() + $loop->iteration }}</td>
        <td class="admin-table-cell text-start">{{ $expense_category->categoryName }}</td>
        <td class="admin-table-cell text-start">{{ $expense_category->categoryDescription }}</td>
        <td class="admin-table-cell">
            <label class="admin-switch">
                <input type="checkbox" {{ $expense_category->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('business.expense-categories.status', $expense_category->id) }}">
                <span class="admin-slider round"></span>
            </label>
        </td>
        <td class="admin-table-cell print-d-none">
            <div class="admin-dropdown table-action">
                <button type="button" class="admin-dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="admin-dropdown-menu">
                    <li>
                        <a href="#expense-categories-edit-modal" data-bs-toggle="modal" class="expense-categories-edit-btn"
                        data-url="{{ route('business.expense-categories.update', $expense_category->id) }}"
                        data-expense-categories-name="{{ $expense_category->categoryName }}" data-expense-categories-description="{{ $expense_category->categoryDescription }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.expense-categories.destroy', $expense_category->id) }}" class="confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
