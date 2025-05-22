@foreach($income_categories as $income_category)
    <tr class="admin-table-row">
        <td class="admin-table-cell admin-checkbox">
            <input type="checkbox" name="ids[]" class="admin-checkbox-item multi-delete" value="{{ $income_category->id }}">
        </td>
        <td class="admin-table-cell">{{ ($income_categories->currentPage() - 1) * $income_categories->perPage() + $loop->iteration }}</td>
        <td class="admin-table-cell text-start">{{ $income_category->categoryName }}</td>
        <td class="admin-table-cell text-start">{{ $income_category->categoryDescription }}</td>
        <td class="admin-table-cell">
            <label class="admin-switch">
                <input type="checkbox" {{ $income_category->status == 1 ? 'checked' : '' }} class="admin-status" data-url="{{ route('business.income-categories.status', $income_category->id) }}">
                <span class="admin-slider round"></span>
            </label>
        </td>
        <td class="admin-table-cell print-d-none">
            <div class="admin-dropdown admin-table-action">
                <button type="button" data-bs-toggle="dropdown" class="admin-dropdown-toggle">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="admin-dropdown-menu">
                    <li>
                        <a href="#income-categories-edit-modal" data-bs-toggle="modal" class="admin-edit-btn income-categories-edit-btn"
                        data-url="{{ route('business.income-categories.update', $income_category->id) }}"
                        data-income-categories-name="{{ $income_category->categoryName }}" data-income-categories-description="{{ $income_category->categoryDescription }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.income-categories.destroy', $income_category->id) }}" class="admin-delete-btn confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
