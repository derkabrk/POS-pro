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
            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Actions') }}">
                <i class="ri-more-2-fill"></i>
            </button>
            <ul class="dropdown-menu">
                @can('shipping-companies-update')
                <li>
                    <a href="{{ route('admin.shipping-companies.edit', $shippingCompany->id) }}" class="dropdown-item">
                        <i class="ri-pencil-fill align-bottom me-2 text-primary"></i>{{__('Edit')}}
                    </a>
                </li>
                @endcan
                @can('shipping-companies-delete')
                <li>
                    <form action="{{ route('admin.shipping-companies.destroy', $shippingCompany->id) }}" method="POST" class="d-inline confirm-action">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="ri-delete-bin-5-fill align-bottom me-2"></i>{{ __('Delete') }}
                        </button>
                    </form>
                </li>
                @endcan
            </ul>
        </div>
    </td>
</tr>
@endforeach
