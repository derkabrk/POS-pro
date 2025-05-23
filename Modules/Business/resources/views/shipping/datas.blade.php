@foreach($shippings as $shipping)
<tr>
    <td class="w-60 checkbox">
        <label class="table-custom-checkbox">
            <span class="table-custom-checkmark custom-checkmark"></span>
        </label>
    </td>
    <td>{{ $loop->index+1 }}</td>
    <td class="text-start">{{ $shipping->name }}</td>
    <td class="text-start">{{ $shipping->shipping_company }}</td>
    <td class="text-start">
        <span class="badge {{ $shipping->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
            {{ $shipping->is_active == 1 ? 'Active' : 'Deactive' }}
        </span>
    </td>
    <td class="print-d-none">
        <div class="d-flex gap-2">
            <a href="{{ route('business.shipping.edit', $shipping->id) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                <i class="fal fa-pencil-alt"></i>
            </a>
            <form action="{{ route('business.shipping.destroy', $shipping) }}" method="POST" class="d-inline confirm-action">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Delete">
                    <i class="fal fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach
