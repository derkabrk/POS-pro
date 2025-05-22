@foreach ($notifications  as $notification)
    <tr>
        <td>{{ $loop->index+1 }}</td>
        <td>{{ $notification->data['message'] ?? '' }}</td>
        <td>{{ formatted_date($notification->created_at, 'd M Y - H:i A') }}</td>
        <td>{{ formatted_date($notification->read_at, 'd M Y - H:i A') }}</td>
        <td>
            <div class="dropdown table-action">
                <button type="button" class="btn btn-link p-0" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('business.notifications.mtView', $notification->id) }}" class="dropdown-item">
                            <i class="fas fa-eye me-1"></i> @lang('View')
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
