@foreach($paymentTypes as $paymentType)
    <tr class="align-middle">
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="form-check-input delete-checkbox-item multi-delete" value="{{ $paymentType->id }}">
        </td>
        <td class="text-muted small">{{ ($paymentTypes->currentPage() - 1) * $paymentTypes->perPage() + $loop->iteration }}</td>
        <td class="text-start fw-semibold">{{ $paymentType->name }}</td>
        <td>
            <span class="badge rounded-pill bg-{{ $paymentType->status == 1 ? 'success' : 'secondary' }} px-3 py-2">
                {{ $paymentType->status == 1 ? __('Active') : __('Inactive') }}
            </span>
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#payment-types-edit-modal" data-bs-toggle="modal" class="dropdown-item payment-types-edit-btn d-flex align-items-center gap-2"
                        data-url="{{ route('business.payment-types.update', $paymentType->id) }}"
                        data-payment-types-name="{{ $paymentType->name }}"
                        data-payment-types-status="{{ $paymentType->status }}"
                        ><i class="ri-edit-2-line"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.payment-types.destroy', $paymentType->id) }}" class="dropdown-item confirm-action d-flex align-items-center gap-2" data-method="DELETE">
                            <i class="ri-delete-bin-6-line text-danger"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
