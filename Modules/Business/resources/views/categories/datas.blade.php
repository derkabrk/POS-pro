@foreach($categories as $category)
    <tr>
        <td style="width: 25px;">
            <div class="form-check">
                <input class="form-check-input delete-checkbox-item multi-delete" type="checkbox" name="ids[]" value="{{ $category->id }}" aria-label="{{ __('Select category') }}">
            </div>
        </td>
        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
        <td>
            <img src="{{ asset($category->icon ?? 'assets/images/logo/upload2.jpg') }}" alt="{{ $category->categoryName }}" class="table-product-img rounded" style="max-width: 40px; max-height: 40px;">
        </td>
        <td class="text-start fw-semibold">{{ $category->categoryName }}</td>
        <td>
            <div class="form-check form-switch justify-content-center d-flex">
                <input class="form-check-input status" type="checkbox" {{ $category->status == 1 ? 'checked' : '' }} data-url="{{ route('business.categories.status', $category->id) }}" aria-label="{{ __('Toggle status') }}">
            </div>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Actions') }}">
                    <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#category-edit-modal" data-bs-toggle="modal" class="dropdown-item category-edit-btn"
                           data-url="{{ route('business.categories.update', $category->id) }}"
                           data-category-name="{{ $category->categoryName }}"
                           data-category-icon="{{ asset($category->icon) }}"
                           data-category-variationcapacity="{{ $category->variationCapacity }}"
                           data-category-variationcolor="{{ $category->variationColor }}"
                           data-category-variationsize="{{ $category->variationSize }}"
                           data-category-variationtype="{{ $category->variationType }}"
                           data-category-variationweight="{{ $category->variationWeight }}">
                            <i class="ri-pencil-fill align-bottom me-2 text-primary"></i>{{__('Edit')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.categories.destroy', $category->id) }}" class="dropdown-item confirm-action text-danger" data-method="DELETE">
                            <i class="ri-delete-bin-5-fill align-bottom me-2"></i>{{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
