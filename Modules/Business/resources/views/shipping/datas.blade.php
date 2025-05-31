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
        <div class="dropdown table-action">
            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Actions') }}">
                <i class="ri-more-2-fill"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('business.shipping.edit', $shipping->id) }}" class="dropdown-item">
                        <i class="ri-pencil-fill align-bottom me-2 text-primary"></i>{{__('Edit')}}
                    </a>
                </li>
                <li>
                    <form action="{{ route('business.shipping.destroy', $shipping) }}" method="POST" class="d-inline confirm-action">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="ri-delete-bin-5-fill align-bottom me-2"></i>{{ __('Delete') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </td>
</tr>
@endforeach
