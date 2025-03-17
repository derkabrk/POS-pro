@foreach ($messages as $message)
    <tr>
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $message->id }}" data-url="{{ route('admin.messages.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $message->name }}</td>
        <td>{{ $message->phone }}</td>
        <td>{{ $message->email }}</td>
        <td>{{ $message->company_name }}</td>
        <td>{{ $message->message }}</td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('messages-delete')
                        <li>
                            <a href="{{ route('admin.messages.destroy', $message->id) }}" class="confirm-action"
                                data-method="DELETE">
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
