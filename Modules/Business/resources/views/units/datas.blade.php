@foreach($units as $unit)
    <tr>
        <td class="w-60 checkbox">
            <div class="form-check">
                <input type="checkbox" name="ids[]" class="form-check-input delete-checkbox-item multi-delete" value="{{ $unit->id }}">
            </div>
        </td>
        <td>{{ ($units->currentPage() - 1) * $units->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $unit->unitName }}</td>
        <td class="text-center">
            <label class="switch">
                <input type="checkbox" {{ $unit->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('business.units.status', $unit->id) }}">
                <span class="slider round"></span>
            </label>
        </td>
        <td class="print-d-none text-center">
            <div class="dropdown table-action">
                <button type="button" class="btn btn-link p-0" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a  href="#unit-edit-modal" data-bs-toggle="modal" class="dropdown-item units-edit-btn" data-url="{{ route('business.units.update', $unit->id) }}" data-units-name="{{ $unit->unitName }}" data-units-status="{{ $unit->status }}"><i class="fal fa-pencil-alt me-1"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.units.destroy', $unit->id) }}" class="dropdown-item confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt me-1"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
