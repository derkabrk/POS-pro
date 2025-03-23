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
        <td class="text-start"> {{ $shipping->is_active == 1 ? 'Active' : 'Deactive' }}</td>

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                        <li><a  href="{{ route('business.shipping.edit', $shipping->id) }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a></li>
                        <li>
                            <a href="{{ route('business.shipping.destroy', $shipping) }}" class="confirm-action" data-method="DELETE">
                            @csrf
                                <i class="fal fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
              
                </ul>
            </div>
        </td>
    </tr>
@endforeach
