@foreach($brands as $brand)
    <tr>
        <td style="width: 25px;">
            <div class="form-check">
                <input class="form-check-input delete-checkbox-item multi-delete" type="checkbox" name="ids[]" value="{{ $brand->id }}" aria-label="{{ __('Select brand') }}">
            </div>
        </td>
        <td>{{ ($brands->currentPage() - 1) * $brands->perPage() + $loop->iteration }}</td>
        <td>
            <img src="{{ asset($brand->icon ?? 'assets/images/logo/upload2.jpg') }}" alt="{{ $brand->brandName }}" class="table-product-img rounded" style="max-width: 40px; max-height: 40px;">
        </td>
        <td class="text-start fw-semibold">{{ $brand->brandName }}</td>
        <td class="text-start text-muted">{{ Str::limit($brand->description, 20, '...') }}</td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input status" type="checkbox" {{ $brand->status == 1 ? 'checked' : '' }} data-url="{{ route('business.brands.status', $brand->id) }}" aria-label="{{ __('Toggle status') }}">
            </div>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Actions') }}">
                    <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#brand-edit-modal" data-bs-toggle="modal" class="dropdown-item brand-edit-btn"
                        data-url="{{ route('business.brands.update', $brand->id) }}"
                        data-brands-name="{{ $brand->brandName }}"
                        data-brands-icon="{{ asset($brand->icon) }}"
                        data-brands-description="{{ $brand->description }}">
                            <i class="ri-pencil-fill align-bottom me-2 text-primary"></i>{{__('Edit')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.brands.destroy', $brand->id) }}" class="dropdown-item confirm-action text-danger" data-method="DELETE">
                            <i class="ri-delete-bin-5-fill align-bottom me-2"></i>{{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
