@foreach($shippingCompanies as $shippingCompany)
    <tr>
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" class="table-hidden-checkbox checkbox-item" name="ids[]" value="{{ $shippingCompany->id }}" data-url="{{ route('admin.shipping-companies.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $loop->index+1 }}</td>
        <td class="text-start">{{ $shippingCompany->name }}</td>
        <td class="text-start">{{ $shippingCompany->email }}</td>
        <td class="text-start">{{ $shippingCompany->address }}</td>
        <td class="text-start">{{ $shippingCompany->contact_number }}</td>

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('shipping-companies-update')
                        <li><a  href="{{ route('admin.shipping-companies.edit', $shippingCompany->id) }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a></li>
                    @endcan
                    @can('shipping-companies-delete')
                        <li>
                            <a href="{{ route('admin.shipping-companies.destroy', $shippingCompany->id) }}" class="confirm-action" data-method="DELETE">
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
