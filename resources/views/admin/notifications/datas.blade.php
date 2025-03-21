@foreach ($notifications  as $notification)
    <tr>
        <td>{{ $loop->index+1 }}</td>
        <td>{{ $notification->data['message'] ?? '' }}</td>
        <td>{{ formatted_date($notification->created_at, 'd M Y - H:i A') }}</td>
        <td>{{ formatted_date($notification->read_at, 'd M Y - H:i A') }}</td>
        <td>
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('admin.notifications.mtView', $notification->id) }}"><i class="fas fa-eye"></i> @lang('View')</a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
