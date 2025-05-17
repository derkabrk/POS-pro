@foreach($income_categories as $income_category)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $income_category->id }}">
        </td>
        <td>{{ ($income_categories->currentPage() - 1) * $income_categories->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $income_category->categoryName }}</td>
        <td class="text-start">{{ $income_category->categoryDescription }}</td>
        <td>
            <label class="switch">
                <input type="checkbox" {{ $income_category->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('business.income-categories.status', $income_category->id) }}">
                <span class="slider round"></span>
            </label>
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a  href="#income-categories-edit-modal" data-bs-toggle="modal" class="income-categories-edit-btn"
                        data-url="{{ route('business.income-categories.update', $income_category->id) }}"
                        data-income-categories-name="{{ $income_category->categoryName }}" data-income-categories-description="{{ $income_category->categoryDescription }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.income-categories.destroy', $income_category->id) }}" class="confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
