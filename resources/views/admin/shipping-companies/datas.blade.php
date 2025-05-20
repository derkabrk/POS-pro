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
        <div class="d-flex gap-2">
            @can('shipping-companies-update')
                <a href="{{ route('admin.shipping-companies.edit', $shippingCompany->id) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                    <i class="fal fa-pencil-alt"></i>
                </a>
            @endcan
            @can('shipping-companies-delete')
                <form action="{{ route('admin.shipping-companies.destroy', $shippingCompany->id) }}" method="POST" class="d-inline confirm-action">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Delete">
                        <i class="fal fa-trash-alt"></i>
                    </button>
                </form>
            @endcan
        </div>
    </td>
</tr>
@endforeach
