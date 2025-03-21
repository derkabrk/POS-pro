@foreach ($newsletters as $newsletter )
    <tr>
        @can('newsletters-delete')
            <td class="checkbox text-start">
                <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $newsletter->id }}" data-url="{{ route('admin.newsletters.delete-all') }}">
            </td>
        @endcan
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $newsletter->email }}</td>
        <td>{{ formatted_date($newsletter->created_at) }}</td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('newsletters-delete')
                        <li>
                            <a href="{{ route('admin.newsletters.destroy', $newsletter->id) }}" class="confirm-action" data-method="DELETE">
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


