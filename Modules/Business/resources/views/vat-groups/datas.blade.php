@foreach ($vat_groups as $vat)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $vat->name }}</td>
        <td class="text-dark fw-bold">{{ $vat->rate }}%</td>
        <td>
            @if(!empty($vat->sub_vat))
                {{ collect($vat->sub_vat)->pluck('name')->implode(', ') }}
            @else
                N/A
            @endif
        </td>
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
                            <a href="{{ route('business.vats.edit', $vat->id) }}">
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
