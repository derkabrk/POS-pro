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
        <div class="d-flex gap-2">
            <a href="#User-view" data-bs-toggle="modal" class="btn btn-sm btn-icon btn-outline-info staff-view-btn"
                data-staff-view-name="{{ $user->name ?? 'N/A' }}"
                data-staff-view-phone-number="{{ $user->phone ?? 'N/A' }}"
                data-staff-view-email-number="{{ $user->email ?? 'N/A' }}"
                data-staff-view-role="{{ $user->role ?? 'N/A' }}"
                title="View">
                <i class="fal fa-eye"></i>
            </a>
            @can('users-update')
                <a href="{{ route('admin.users.edit', [$user->id, 'users' => $user->role]) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                    <i class="fal fa-pencil-alt"></i>
                </a>
            @endcan
            @can('users-delete')
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline confirm-action">
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
