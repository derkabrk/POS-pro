@foreach ($users as $user)
<tr>
    <td class="w-60 checkbox">
        <label class="table-custom-checkbox">
            <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $user->id }}" data-url="{{ route('admin.users.delete-all') }}">
            <span class="table-custom-checkmark custom-checkmark"></span>
        </label>
    </td>
    <td>{{ $loop->index + 1 }}</td>
    <td class="text-start">{{ $user->name }}</td>
    <td class="text-start">{{ $user->phone }}</td>
    <td class="text-start">{{ $user->email }}</td>
    <td class="text-start">{{ $user->role }}</td>
    <td class="print-d-none">
        <div class="dropdown table-action">
            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Actions') }}">
                <i class="ri-more-2-fill"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#User-view" data-bs-toggle="modal" class="dropdown-item staff-view-btn"
                        data-staff-view-name="{{ $user->name ?? 'N/A' }}"
                        data-staff-view-phone-number="{{ $user->phone ?? 'N/A' }}"
                        data-staff-view-email-number="{{ $user->email ?? 'N/A' }}"
                        data-staff-view-role="{{ $user->role ?? 'N/A' }}"
                        title="View">
                        <i class="ri-eye-fill align-bottom me-2 text-info"></i>{{__('View')}}
                    </a>
                </li>
                @can('users-update')
                <li>
                    <a href="{{ route('admin.users.edit', [$user->id, 'users' => $user->role]) }}" class="dropdown-item" title="Edit">
                        <i class="ri-pencil-fill align-bottom me-2 text-primary"></i>{{__('Edit')}}
                    </a>
                </li>
                @endcan
                @can('users-delete')
                <li>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline confirm-action">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger" title="Delete">
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
