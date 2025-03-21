@foreach ($vats as $vat)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item multi-delete" value="{{ $vat->id }}">
        </td>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $vat->name }}</td>
        <td class="text-dark fw-bold">{{ $vat->rate }}%</td>
        <td class="text-center w-150">
            <label class="switch">
                <input type="checkbox" {{ $vat->status == 1 ? 'checked' : '' }} class="status"
                    data-url="{{ route('business.vats.status', $vat->id) }}">
                <span class="slider round"></span>
            </label>
        </td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown"><i class="far fa-ellipsis-v"></i></button>
                <ul class="dropdown-menu">


                        <li>
                            <a href="#vat-edit-modal" class="vat-edit-btn" data-bs-toggle="modal"
                               data-url="{{ route('business.vats.update', $vat->id) }}"
                               data-vat-name="{{ $vat->name }}" data-vat-code="{{ $vat->code }}"
                               data-vat-rate="{{ $vat->vat_rate }}" data-new-vat-rate="{{ $vat->rate }}"
                               data-vat-status="{{ $vat->status }}"
                            >
                                <i class="fal fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('business.vats.destroy', $vat->id) }}" class="confirm-action"
                                data-method="DELETE">
                                    <i class="fal fa-trash-alt"></i>
                                    {{ __('Delete') }}
                            </a>
                        </li>

                </ul>
            </div>
        </td>
    </tr>
@endforeach

