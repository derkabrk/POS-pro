@foreach($Shipping as $Shipping)
    <tr>
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" class="table-hidden-checkbox checkbox-item" name="ids[]" value="{{ $Shipping->id }}" data-url="{{ route('admin.shipping-companies.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $loop->index+1 }}</td>
        <td class="text-start">{{ $Shipping->name }}</td>
        <td class="text-start">{{ $Shipping->email }}</td>
        <td class="text-start">{{ $Shipping->address }}</td>
        <td class="text-start">{{ $Shipping->contact_number }}</td>

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('shipping-companies-update')
                        <li><a  href="{{ route('admin.shipping-companies.edit', $Shipping->id) }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a></li>
                    @endcan
                    @can('shipping-companies-delete')
                        <li>
                            <a href="{{ route('admin.shipping-companies.destroy', $Shipping->id) }}" class="confirm-action" data-method="DELETE">
                                <i class="fal fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </td>
    </tr>
@endforeach
