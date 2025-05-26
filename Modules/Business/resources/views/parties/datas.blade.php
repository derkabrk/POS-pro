@foreach ($parties as $party)
    <tr>
        <td class="w-60 d-print-none">
            <div class="form-check">
                <input type="checkbox" name="ids[]" class="form-check-input delete-checkbox-item multi-delete" value="{{ $party->id }}">
            </div>
        </td>
        <td>{{ ($parties->currentPage() - 1) * $parties->perPage() + $loop->iteration }}</td>
        <td>
            <img src="{{ asset($party->image ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="table-product-img" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px;">
        </td>
        <td>{{ $party->name }}</td>
        <td>{{ $party->email }}</td>
        <td>{{ $party->type }}</td>
        <td>{{ $party->phone }}</td>
        <td class="text-danger">{{ currency_format($party->due, 'icon', 2, business_currency()) }}</td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown" class="btn btn-link p-0 border-0">
                    <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('business.sales.create', ['customer_id' => $party->id]) }}"><i class="ri-add-line"></i>{{ __('Add') }}</a>
                    </li>
                    <li>
                        <a href="#parties-view" class="parties-view-btn" data-bs-toggle="modal"
                            data-name="{{ $party->name }}" data-email="{{ $party->email }}"
                            data-phone="{{ $party->phone }}" data-type="{{ $party->type }}"
                            data-due="{{ currency_format($party->due, 'icon', 2, business_currency()) }}" data-address="{{ $party->address }}">
                            <i class="ri-eye-line"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.parties.edit', [$party->id, 'type' => request('type')]) }}"><i class="ri-edit-line"></i>{{ __('Edit') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.parties.destroy', $party->id) }}" class="confirm-action"
                            data-method="DELETE">
                            <i class="ri-delete-bin-line"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
