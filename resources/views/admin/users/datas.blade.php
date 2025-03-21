@foreach ($users as $user)
    <tr>
        <td class="w-60 checkbox">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item" value="{{ $user->id }}"
                data-url="{{ route('admin.users.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
            <i class=""></i>
        </td>
        <td>{{ $loop->index + 1 }}</td>
        <td class="text-start">{{ $user->name }}</td>
        <td class="text-start">{{ $user->phone }}</td>
        <td class="text-start">{{ $user->email }}</td>
        <td class="text-start">{{ $user->role }}</td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#User-view" data-bs-toggle="modal" class="staff-view-btn"
                            data-staff-view-name="{{ $user->name ?? 'N/A' }}"
                            data-staff-view-phone-number="{{ $user->phone ?? 'N/A' }}"
                            data-staff-view-email-number="{{ $user->email ?? 'N/A' }}"
                            data-staff-view-role="{{ $user->role ?? 'N/A' }}"> <i
                                class="fal fa-eye"></i>{{ __('View') }}</a></li>
                    @can('users-update')
                        <li>
                            <a href="{{ route('admin.users.edit', [$user->id, 'users' => $user->role]) }}">
                                <i class="fal fa-pencil-alt"></i>{{ __('Edit') }}
                            </a>
                        </li>
                    @endcan
                    @can('users-delete')
                        <li>
                            <a href="{{ route('admin.users.destroy', $user->id) }}" class="confirm-action"
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
